window.onload = () =>{
    const html = document.body;

    // javascript navbar
    function showNavbar(){
        const navbar = document.querySelector('.navbar-menu');
        const mainContent = document.querySelector('.main-content');
        const icon = document.querySelector('.navbarIcon');

        icon.classList.toggle('clicked');
        navbar.classList.toggle('show');
        mainContent.classList.toggle('navbar-opened');
    }
    if(html.contains(document.querySelector('.navbar-icon'))){
        document.querySelector('.navbar-icon').addEventListener('click', showNavbar);
        document.querySelector('.navbarIcon').addEventListener('click', showNavbar);
    }

    // javascript form
    if(html.contains(document.querySelector('#form-insert')) && html.contains(document.querySelector('.show-form'))){
        const formInsert = document.querySelector('#form-insert');
        const formShow = document.querySelector('.show-form');

        formShow.addEventListener('click', () =>{
            formInsert.classList.toggle('show');
            if(document.querySelector('.navbar-menu').classList.contains('show')){
                showNavbar();
            }
        })
        console.log('form show & insert exist');
    }

    if(html.contains(document.querySelector('.table-wrapper'))){
        const tableWrap = document.querySelector('.table-wrapper');
        const firstCol = document.querySelectorAll('.first-col');
        tableWrap.addEventListener('scroll', () =>{
            if(tableWrap.scrollLeft > 0){
                for(i=0;i<firstCol.length;i++){
                    firstCol[i].classList.add("scrolled");
                }
            } else{
                for(i=0;i<firstCol.length;i++){
                    firstCol[i].classList.remove("scrolled");
                }
            }
        })
        
    }
}