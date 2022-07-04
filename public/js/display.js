const btnAdd =  document.querySelector('.add');
const btnSee =  document.querySelector('.see');
const formBlock = document.querySelector('.formBox');

btnAdd.addEventListener('click', ()=> {
    formBlock.classList.toggle('display');
});

/* SCRIPT EMBED FORM */

//add delete this tag link to each tag from
const lis = document.querySelectorAll('ul.materials li')
 
lis.forEach((material) => {
      addTagFormDeleteLink(material);

  })

  const addTagFormDeleteLink = (item) => {
    const removeFormButton = document.createElement('button');
   removeFormButton.className ='btn btn-danger btn-sm ms-2';
    removeFormButton.innerText = 'Delete';

    item.append(removeFormButton);

    removeFormButton.addEventListener('click', (e) => {
        e.preventDefault();
        // remove the li for the tag form
        item.remove();
    });
}



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
    
    //add a delete link to the new form
    addTagFormDeleteLink(item);
  };


 const btn = document.querySelector('.add_item_link');


 //primary function
  btn.addEventListener('click', addFormToCollection);

