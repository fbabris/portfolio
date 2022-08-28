let skillsPosition = rect(document.querySelector('.skills'));
let portfolioPosition = rect(document.querySelector('.portfolio'));
let contactPosition = rect(document.querySelector('.contact'));
let navbar = document.querySelector(".menu").querySelectorAll("a");
let menuScrollbar = document.querySelector("#nav-wrapper").querySelectorAll('a');
let portfolio_nav = document.querySelector('.portfolio_nav').querySelectorAll('a');
let toggleButton = document.querySelector('.menu_toggle');

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

toggleButton.addEventListener("click", function(){
    let toggleMenu = document.querySelector('.menu_items');
    if (toggleButton.classList.contains("open")){
        toggleButton.classList.replace("open", "closed");
        toggleMenu.classList.replace("closed", "open");
        document.querySelector('#menu_mobile').classList.remove('hidden');
    }
    toggleButton.classList.replace("closed", "open");
    toggleMenu.classList.replace("open", "closed");
    document.querySelector('#menu_mobile').classList.add('hidden');
}); 

//----showing slide depending on active navbar option----

function setActiveSlide(slideId){
  let slides = document.querySelectorAll('.slides');
  slides.forEach(element => 
    element.classList.remove('shown')
  );
  document.getElementById(slideId).classList.add('shown');
}

//----email request handler

let form = document.querySelector('.form');
let target = document.getElementById('status_messages');
let serverMessage = document.getElementById('server_message');
form.addEventListener('submit', function(e) {
  e.preventDefault();

  const formData = new FormData(this);

  fetch('api.php?api-name=email', {
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
  });
});




  // let req = new XMLHttpRequest();
  // req.open('POST', 'api.php')
  // req.send(data);
  // req.onreadystatechange = function(){
  //   if(this.readyState==4&& this.status ==200){
  //     let response = JSON.parse(req.responseText);
  //     let responseStatus = response.status;
  //     let target = document.querySelector('#status_messages');
  //     let serverMessage = document.getElementById('server_message');
  //     if (responseStatus == 1){
  //       target.classList.remove('error');
  //       target.classList.add('success');
  //       form.reset();
  //     }
  //     else if (responseStatus == 0){
  //       target.classList.remove('success');
  //       target.classList.add('error');
  //     }
  //     serverMessage.textContent = response.message;
  //     setTimeout(function(){
  //       target.classList.remove('success');
  //       target.classList.remove('error');
  //       serverMessage.textContent = '';
  //     }, 4000);
  //   }
  // };  


//----disabling the submit button for 5 seconds after form is submitted to prevent multiple submissions----

function timeout(){
  let btn = document.getElementById('submit');
  btn.disabled = true;
  setTimeout(function(){
    btn.disabled = false;
  }, 5000)
}

