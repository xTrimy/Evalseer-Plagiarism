// require('./bootstrap');
hljs = require('highlight.js');

document.addEventListener("DOMContentLoaded", function(){
    var modal_close = document.getElementsByClassName('close_this_modal');
    for(let i = 0; i<modal_close.length; i++){
        modal_close[i].addEventListener('click',function(){
            this.closest('.this_modal').classList.add('hidden');
        });
    }
    var modal_open = document.getElementsByClassName('modal_open');
    for(let i = 0; i<modal_open.length; i++){
        modal_open[i].addEventListener('click',function(){
            var modal = document.querySelector('.this_modal');
            var modal_title = this.getAttribute('data-modal-title');
            var modal_close_button = this.getAttribute('data-modal-close-button');
            modal.querySelector('.modal_title').innerHTML = modal_title;
            modal.querySelector('.modal_close_button').innerHTML = modal_close_button;
            modal.querySelector('.modal_content').innerHTML = this.parentElement.querySelector('.modal_contains').innerHTML;
            modal.classList.remove('hidden');
        });
    }
});