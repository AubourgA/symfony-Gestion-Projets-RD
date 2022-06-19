const btnAdd =  document.querySelector('.add');
const btnSee =  document.querySelector('.see');
const formBlock = document.querySelector('.formBox');

btnAdd.addEventListener('click', ()=> {
    formBlock.classList.toggle('display');
});

/* SCRIPT EMBED FORM */

const addFormToCollection = (e) => {
    const collectionHolder = document.querySelector('.' + e.currentTarget.dataset.collectionHolderClass);
 
    const item = document.createElement('li');
  
    item.innerHTML = collectionHolder
      .dataset
      .prototype
      .replace(
        /__name__/g,
        collectionHolder.dataset.index
      );
  
    collectionHolder.appendChild(item);
  
    collectionHolder.dataset.index++;
  };


 const btn = document.querySelector('.add_item_link');


  btn.addEventListener('click', addFormToCollection);