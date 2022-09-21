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

let reviewForm = document.getElementById('review_form');
reviewForm.addEventListener('submit', function(e) {
  e.preventDefault();

  target = document.getElementById('rev_status_messages');
  serverMessage = document.getElementById('rev_server_message');

  const reviewformData = new FormData(this);

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
    serverMessage.textContent = text.srvmessage;
        setTimeout(function(){
          target.classList.remove('success');
          target.classList.remove('error');
          serverMessage.textContent = '';
          closeReview();
        }, 4000);
  });
});



function renderNextReview(name, text, date){
  let reviewTemplate=document.getElementById('review').content;
  let clone = document.importNode(reviewTemplate, true);
  clone.querySelector('.review_name').textContent = name;
  clone.querySelector('.review_text').textContent = text;
  clone.querySelector('.review_date').textContent = date;
  document.getElementById('review_row').appendChild(clone);
}

// ---- onload event for rendering all reviews

window.addEventListener('load', ()=>{
  fetch('./Helpers/includes/Review.inc.php').then(function(response){
    return response.text();
  }).then(function (text){
    let shmext = JSON.parse(text);
    for (review in shmext){
      renderNextReview(shmext[review]['user_name'], shmext[review]['review_text'], shmext[review]['review_date']);
    }
  });
});