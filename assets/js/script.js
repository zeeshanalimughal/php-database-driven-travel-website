let sidebar = document.querySelector(".sidebar");
let toggle = document.querySelector(".toggle");
let main = document.querySelector(".main");

toggle.addEventListener("click",(e)=>{
    e.preventDefault();
    sidebar.classList.toggle("active");
    sidebar.classList.toggle("col-3");
    main.classList.toggle("col-12");
})



// gALLERY SCRIPPT
