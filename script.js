let toggleButton = document.querySelector('.menu_toggle');
let toggleMenu = document.querySelector('.menu_items');
let skillsPosition = rect(document.querySelector('.skills'));
let portfolioPosition = rect(document.querySelector('.portfolio'));
let contactPosition = rect(document.querySelector('.contact'));
let navbar = document.querySelector(".menu").querySelectorAll("a");
let menuScrollbar = document.querySelector("#nav-wrapper").querySelectorAll('a');
let portfolio_nav = document.querySelector('.portfolio_nav').querySelectorAll('a');
let activePortfolioNav = document.querySelector('.portfolio_nav').querySelector('.active').id;
 
window.addEventListener('resize', resizeAdjust);

function resizeAdjust(){
  skillsPosition = rect(document.querySelector('.skills'));
  portfolioPosition = rect(document.querySelector('.portfolio'));
  contactPosition = rect(document.querySelector('.contact'));
}

setTimeout(resizeAdjust, 600);

toggleButton.addEventListener("click", toggleSidebar);

setActiveClassOnClick(navbar);
setActiveClassOnClick(portfolio_nav);
onscroll = (event) => {
  setActiveClassOnScroll(navbar);
  setActiveClassOnScroll(menuScrollbar);
};

function setActiveSlide(slideId){
  let slides = document.querySelectorAll('.slides');
  slides.forEach(element => 
    element.classList.remove('shown')
  );
  document.getElementById(slideId).classList.add('shown');
}

function rect(elementname) {
  return elementname.getBoundingClientRect().top + window.scrollY;
}

function toggleSidebar() {
  if (toggleButton.classList.contains("open")){
    toggleButton.classList.replace("open", "closed");
    toggleMenu.classList.replace("closed", "open");
    document.querySelector('#menu_mobile').classList.remove('hidden');
  }
  else{
    toggleButton.classList.replace("closed", "open");
    toggleMenu.classList.replace("open", "closed");
    document.querySelector('#menu_mobile').classList.add('hidden');
  }
}

function setActiveClassOnClick(items){
  items.forEach(element => {
    element.addEventListener("click", function(){
        items.forEach(link => link.classList.remove("active"));
        this.classList.add("active");
    })
  })
};

function setActiveClassOnScroll(element){
  element.forEach(link => link.classList.remove("active"));
  
let navHome = document.getElementsByClassName('navHome');
let navSkills = document.getElementsByClassName('navSkills');
let navPortfolio = document.getElementsByClassName('navPortfolio');
let navContact = document.getElementsByClassName('navContact');

  if (document.documentElement.scrollTop > skillsPosition-100){    
    document.querySelector('#nav-wrapper').classList.remove('hidden');
  }
  else {
    document.querySelector('#nav-wrapper').classList.add('hidden');
  }
  
  if (document.documentElement.scrollTop <= skillsPosition-100){    
    for (nav of navHome) {nav.classList.add('active')};
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


document.querySelector('.form').addEventListener('submit', function(event){
  event.preventDefault();
  timeout();
  let form = document.querySelector('.form');
  let data = new FormData(form);
  let req = new XMLHttpRequest();
  req.open('POST', 'process.php')
  req.send(data);
  req.onreadystatechange = function(){
    if(this.readyState==4&& this.status ==200){
      let response = JSON.parse(req.responseText);
      let response_status = response.status;
      let target = document.querySelector('#status_messages');
      let server_message = document.getElementById('server_message');
      if (response_status == 1){
        target.classList.remove('error');
        target.classList.add('success');
        form.reset();
      }
      else if (response_status == 0){
        target.classList.remove('success');
        target.classList.add('error');
      }
      server_message.textContent = response.message;
    }
  };  
})

let btn = document.getElementById('submit');

function timeout(){
  btn.disabled = true;
  setTimeout(notDisabled, 5000)
}

function notDisabled(){
  btn.disabled = false;
}