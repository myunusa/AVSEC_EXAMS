const scrollBtn2 = document.querySelector('.scroll_top');

window.addEventListener('scroll',() =>{
    if( document.body.scrollTop > 20 || document.documentElement.scrollTop > 20){
        scrollBtn2.style.display ="block";
    }else{
        scrollBtn2.style.display ="none";
    }
})

scrollBtn2.addEventListener('click', () =>{
    window.scroll({
        top:0, behavior:"smooth"
    })
});
