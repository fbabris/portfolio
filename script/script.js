let skillsPosition = rect(document.querySelector('.skills'));
let portfolioPosition = rect(document.querySelector('.portfolio'));
let contactPosition = rect(document.querySelector('.contact'));
let navbar = document.querySelector(".menu").querySelectorAll("a");
let menuScrollbar = document.querySelector("#nav-wrapper").querySelectorAll('a');
let portfolio_nav = document.querySelector('.portfolio_nav').querySelectorAll('a');

//----updating vertical position variables in case of browser resize----

setTimeout(function(){
  window.addEventListener('resize', function(){
      skillsPosition = rect(document.querySelector('.skills'));
      portfolioPosition = rect(document.querySelector('.portfolio'));
      contactPosition = rect(document.querySelector('.contact'));
  });
}, 600);

//----setting active class in all navbars for scroll----

onscroll = (event) => {
    setActiveClassOnScroll(navbar);
    setActiveClassOnScroll(menuScrollbar);
};
  
function setActiveClassOnScroll(element){
  element.forEach(link => link.classList.remove("active"));

  let navHome = document.getElementsByClassName('navHome');
  let navSkills = document.getElementsByClassName('navSkills');
  let navPortfolio = document.getElementsByClassName('navPortfolio');
  let navContact = document.getElementsByClassName('navContact');
  document.querySelector('#nav-wrapper').classList.remove('hidden');

  if (document.documentElement.scrollTop <= skillsPosition-100){    
    for (nav of navHome) {nav.classList.add('active')};
    document.querySelector('#nav-wrapper').classList.add('hidden');
  }

  else if (portfolioPosition-100 >= document.documentElement.scrollTop && document.documentElement.scrollTop > skillsPosition-100){
    for (nav of navSkills) {nav.classList.add('active')};
  }

  else if (contactPosition-100 >= document.documentElement.scrollTop && document.documentElement.scrollTop > portfolioPosition-100){
    for (nav of navPortfolio) {nav.classList.add('active')};
  }

  else {
    for (nav of navContact) {nav.classList.add('active')};
  }
}

function rect(elementname) {
  return elementname.getBoundingClientRect().top + window.scrollY;
}

//----setting active class in all navbars on click----

setActiveClassOnClick(navbar);
setActiveClassOnClick(portfolio_nav);

function setActiveClassOnClick(items){
  items.forEach(element => {
      element.addEventListener("click", function(){
          items.forEach(link => link.classList.remove("active"));
          this.classList.add("active");
      })
  })
};

//----toggling mobile menu between open/closed state----

document.querySelector('.menu_toggle').addEventListener('click', function(e){
  e.preventDefault();
  toggleElement(document.querySelector('.menu_toggle'), document.querySelector('.menu_items'), document.querySelector('#menu_mobile'));
});

document.querySelector('.review_btn').addEventListener('click', function(e){
  e.preventDefault();
  toggleElement(document.querySelector('.review_btn'), document.querySelector('#review_form'), document.querySelector('#review_container'));
});

function toggleElement(toggleHook, toggleElm, toggleBlock) {
    if (toggleHook.classList.contains('open')){
        toggleHook.classList.replace('open', 'closed');
        toggleElm.classList.replace('closed', 'open');
        toggleBlock.classList.remove('hidden');
    }
    else {toggleHook.classList.replace("closed", "open");
    toggleElm.classList.replace("open", "closed");
    toggleBlock.classList.add('hidden')};
}; 

function closeReview(){
    document.querySelector('.review_btn').classList.replace("closed", "open");
    document.querySelector('#review_form').classList.replace("open", "closed");
    document.querySelector('#review_container').classList.add('hidden')
}

//----showing slide depending on active navbar option----

function setActiveSlide(slideId){
  let slides = document.querySelectorAll('.slides');
  slides.forEach(element => 
    element.classList.remove('shown')
  );
  document.getElementById(slideId).classList.add('shown');
}

//----email request handler
let btn1 = document.getElementById('submit');
let form = document.querySelector('.form');
let target;
let serverMessage;
form.addEventListener('submit', function(e) {
  e.preventDefault();

  target = document.getElementById('status_messages');
  serverMessage = document.getElementById('server_message'); 
  
  btn1.disabled = true;
  btn1.value = 'Lūdzu uzgaidiet!';  

  const formData = new FormData(this);

  fetch('./Helpers/includes/Email.inc.php', {
    method: 'post',
    body: formData
  }).then(function(response){
    return response.text();
  }).then(function (text){
    text=JSON.parse(text);
    if (text.status == 1){
      target.classList.remove('error');
      target.classList.add('success');
      form.reset();
    }
    else if (text.status == 0){
      target.classList.remove('success');
      target.classList.add('error');
    }
    serverMessage.textContent = text.srvmessage;
        setTimeout(function(){
          target.classList.remove('success');
          target.classList.remove('error');
          serverMessage.textContent = '';
        }, 4000);
    btn1.value = 'Iesniegt';
    btn1.disabled = false;
  });
});

//----review request handler
document.getElementById('upload_button').addEventListener('click', (e)=>{
  e.preventDefault();
  document.getElementById('profile_picture').click();
});

let profilePicture = document.getElementById('profile_picture');

let reviewForm = document.getElementById('review_form');
let btn2 = document.getElementById('review_submit');
reviewForm.addEventListener('submit', function(e) {
  e.preventDefault();
  console.log(profilePicture.files[0]);
  target = document.getElementById('rev_status_messages');
  serverMessage = document.getElementById('rev_server_message');
  btn2.disabled = true;
  btn2.value = 'lūdzu, uzgaidiet!'
  const reviewformData = new FormData(this);
  reviewformData.append('profile_picture', profilePicture.files[0]);

  fetch('./Helpers/includes/Review.inc.php?api=new_review', {
    method: 'post',
    body: reviewformData
  }).then(function(response){
    return response.text();
  }).then(function (text){
    text=JSON.parse(text);
    if (text.status == 1){
      target.classList.remove('error');
      target.classList.add('success');
      reviewForm.reset();
    }
    else if (text.status == 0){
      target.classList.remove('success');
      target.classList.add('error');
    }
    btn2.disabled = false;
    btn2.value = 'Iesniegt atsauksmi';
    serverMessage.textContent = text.srvmessage;
        setTimeout(function(){
          target.classList.remove('success');
          target.classList.remove('error');
          serverMessage.textContent = '';
          closeReview();
        }, 4000);
  });
});

// ---- onload event for rendering all reviews
window.addEventListener('load', ()=>{
  fetch('./Helpers/includes/Review.inc.php').then(function(response){
    return response.text();
  }).then(function (text){
    let shmext = JSON.parse(text);
    let index = 1;
    let reviewClass;
    for (review in shmext){
      reviewClass = 'review'+index;
      renderNextReview(shmext[review]['user_name'], shmext[review]['review_text'], shmext[review]['review_date'], reviewClass, shmext[review]['review_picture']);
      index++;
    }

    let reviews = document.querySelectorAll('.review_single');
    reviews.forEach(review => {review.addEventListener('click', function(){
      renderBigReview(this.id);
      });
    });

    new Glider(document.querySelector('.glider'), {
      // Mobile-first defaults
      slidesToShow: 1,
      slidesToScroll: 1,
      scrollLock: true,
      dots: '.dots',
      arrows: {
        prev: '.glider-prev',
        next: '.glider-next'
      },
      responsive: [
        {
          // screens greater than >= 775px
          breakpoint: 775,
          settings: {
            // Set to `auto` and provide item width to adjust to viewport
            slidesToShow: 2,
            slidesToScroll: 2,
            itemWidth: 150,
            duration: 0.25
          }
        },{
          // screens greater than >= 1024px
          breakpoint: 1024,
          settings: {
            slidesToShow: 3,
            slidesToScroll: 3,
            itemWidth: 150,
            duration: 0.25
          }
        },{
          // screens greater than >= 1485px
          breakpoint: 1482,
          settings: {
            slidesToShow: 4,
            slidesToScroll: 4,
            itemWidth: 150,
            duration: 0.25
          }
        }
      ]
    });
    // autoSlider(index);
  });
});

function renderNextReview(name, text, date, reviewClass, picture){
  let reviewTemplate=document.getElementById('review').content;
  let clone = document.importNode(reviewTemplate, true);
  let div = clone.getElementById('randomId');
  div.id = reviewClass;
  clone.querySelector('.review_name').textContent = name;
  clone.querySelector('.review_text').textContent = text;
  clone.querySelector('.review_date').textContent = date;
  clone.querySelector('.review_picture').src = "./img/profilepics/" + picture;
  document.getElementById('review_row').appendChild(clone);
}

function renderBigReview(id){
  let bigTemplate = document.querySelector('#reviewBig').content;
  let bigClone = document.importNode(bigTemplate, true);
  let reviewSrc = document.getElementById(id);
  let bigName = reviewSrc.querySelector('.review_name').textContent;
  let bigText = reviewSrc.querySelector('.review_text').textContent;
  let bigDate = reviewSrc.querySelector('.review_date').textContent;
  let bigPic = reviewSrc.querySelector('.review_picture').src;
  bigPic = bigPic.split('/');
  bigPic = "./img/profilepics/big/" + bigPic[bigPic.length-1];
  bigClone.querySelector('.review_big_single_box_name').textContent = bigName;
  bigClone.querySelector('.review_big_single_box_text').textContent = bigText;
  bigClone.querySelector('.review_big_single_box_date').textContent = bigDate;
  bigClone.querySelector('.review_big_single_pic_wrapped').src = bigPic;
  document.querySelector('.review').appendChild(bigClone);
  let bigBadButton = document.querySelector('.review_big_btn');
    bigBadButton.addEventListener('click', function(e){
      e.preventDefault();
      document.querySelector('.review').removeChild(document.querySelector('.review_big'));
  });
}