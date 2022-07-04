window.onload = () => {

const allcheckbox = document.querySelectorAll('input[type=checkbox]');

const btn = document.querySelector('.cta');

let tableau = [];

btn.addEventListener('click', (e)=> {
    e.preventDefault();
    tableau=[];
    allcheckbox.forEach( item => {
        if(item.checked) {
            tableau.push(item.name);
        } 
    })

 if(tableau.length > 0) {
 
    
   }
 })
}