const btnDelete = document.querySelectorAll('.cta');
const boxModal = document.querySelector('.alert-modal');
const btnValid = document.querySelector('.btn-valid');
const btnCancel = document.querySelector('.btn-cancel');

let idButton;
let path;

function launchModal(e) {
   boxModal.classList.add('active');
   idButton = e.target.dataset.id;
   path = e.target.dataset.path;
   console.log(path);
}



btnDelete.forEach( item => {
    item.addEventListener('click', launchModal);
})

btnCancel.addEventListener('click', ()=> {
    boxModal.classList.remove('active');
})

btnValid.addEventListener('click', ()=> {
  btnValid.href= `${path}/${idButton}`
});