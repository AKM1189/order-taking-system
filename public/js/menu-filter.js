// let category = document.getElementsByClassName('category')[0];
// let menu = document.getElementsByClassName('menu')[0];
// let allcategory = document.getElementsByClassName('allcategory')[0];

// document.addEventListener('DOMContentLoaded', function() {

//     // Fetch data from database
//     fetch('/order/categories')
//         .then(response => response.json())
//         .then(data => displaycategory(data.categories, data.menus))
//         .catch(err => console.log(err));

//     // fetch('/order/menus')
//     // .then(response => response.json())
//     // .then(data => display)
// })

// function displaycategory(categories, menus) {
//     // category.innerHTML = '';
//     categories.forEach(item => {
//         let tr = document.createElement('tr');
//         let td = document.createElement('td');

//         td.textContent = item.categoryname;
//         tr.appendChild(td);
//         // div.innerHTML += '<td>' + item.categoryname + '</td>';
//         category.appendChild(tr);

//         console.log(category);

//         tr.addEventListener('click', function() {
//             let categoryname = item.categoryname;
//             let categoryid = item.id;
//             menu.innerHTML = '';
//             menus.forEach(menuitem => {
//                 if (menuitem.category_id == categoryid) {
//                     let menudiv = document.createElement('div');
//                     menudiv.textContent = menuitem.menuname;
//                     menu.appendChild(menudiv);
//                 }
//             })
//         })
//     })

//     allcategory.addEventListener('click', function() {
//         menu.innerHTML = '';

//         menus.forEach(menuitem => {
//             let div = document.createElement('div');

//             div.textContent = menuitem.menuname;
//             menu.appendChild(div);
//         })
//     })
//     menu.innerHTML = '';
//     menus.forEach(menuitem => {

//         menu.appendChild('<tr>' +
//                 '<td>' + menuitem.id + '</td>' +
//                 '<td>' + menuitem.menuname + '</td>' +
//                 '<td>' + menuitem.quantity + '</td>'

//                 +
//                 '</tr>')
//             // let tr = document.createElement('tr');

//         // tr.appendChild(td)
//         // for (let i = 0; i < menuitem.length; i++) {
//         //     let td = document.createElement('td');
//         //     td.textContent = menu.id;
//         //     ;
//         // }
//         // console.log(menuitem);
//         // menuitem.forEach(menu => {

//         // })

//         // td.textContent = menuitem.menuname;
//         // menu.appendChild(tr);
//     })
// }

// const category = document.getElementById('category');

// category.addEventListener('change', function(e) {
//     console.log(e.target.value);
// })
