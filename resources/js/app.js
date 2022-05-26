const { replace } = require('lodash');

// require('./bootstrap');
files = require('./fileIcons.js');
hljs = require('highlight.js');

function findId(id, arr) {
  return arr.reduce((a, item) => {
    if (a) return a;
    if (item.ids.includes(id)) return item;
    if (item.children) return findId(id, item.children);
  }, null);
}

window.tab_file_orders=1;

window.edit_file_tab_names = function(){

    var file_tabs = document.getElementsByClassName('file_tab');
    for(let i = 0; i<file_tabs.length; i++){
        if(file_tabs[i].getAttribute("id") == "add_file_button") continue;
        if(file_tabs[i].querySelector('.remove_file')){
            file_tabs[i].querySelector('.remove_file').onclick = function(){
                remove_ide_editor(file_tabs[i].getAttribute('data-file-order'));
                file_tabs[i].remove();
                setTimeout(() => {
                    select_file_tab(file_tabs[0]);
                }, 100);
            }
        }
        file_tabs[i].onclick = function(){
            select_file_tab(this);
            console.log(this);
        }
        file_tabs[i].ondblclick = function (){
            this.querySelector('input').value = this.querySelector('.file_name').innerHTML;
            this.querySelector('input').classList.remove('hidden');
            this.querySelector('input').focus();
            this.querySelector('.file_name').classList.add('opacity-0');
        };
        file_tabs[i].querySelector('input').onblur = function(){
            file_tabs[i].querySelector('input').classList.add('hidden');
            file_tabs[i].querySelector('.file_name').classList.remove('opacity-0');
            if(file_tabs[i].querySelector('.file_name').innerHTML == "Enter file name"){
                file_tabs[i].remove();
            }
        };
        file_tabs[i].onkeydown = function(e){
            if(e.key == "Enter"){
                e.preventDefault();
                if(file_tabs[i].querySelector('input').value !== ""){
                    let new_file = false;
                    if(file_tabs[i].querySelector('.file_name').innerHTML == "Enter file name"){
                        new_file = true;
                    }
                    file_tabs[i].querySelector('.file_name').innerHTML = file_tabs[i].querySelector('input').value;
                    let lang = get_file_lang(file_tabs[i]);
                    if(new_file){
                        add_ide_editor(lang,tab_file_orders);
                        select_file_tab(file_tabs[i]);
                    }else{
                        let lang = get_file_lang(file_tabs[i]);
                        let file_order = file_tabs[i].getAttribute('data-file-order');
                        edit_ide_editor_mode(lang,file_order);
                    }
                }
                else{
                    if(file_tabs[i].querySelector('.file_name').innerHTML == "Enter file name"){
                        file_tabs[i].remove();
                        return;
                    }
                }
                file_tabs[i].querySelector('input').classList.add('hidden');
                file_tabs[i].querySelector('.file_name').classList.remove('opacity-0');
            }else if(e.key == "Escape"){
                if(file_tabs[i].querySelector('.file_name').innerHTML == "Enter file name"){
                        file_tabs[i].remove();
                }
                file_tabs[i].querySelector('input').classList.add('hidden');
                file_tabs[i].querySelector('.file_name').classList.remove('opacity-0');
            }
            add_file_icons_to_files();
        };
    }
}


window.select_file_tab = function(element){
    remove_file_tabs_selection();
    element.classList.add('current_file_tab');
    element.classList.add('bg-slate-800');
    element.classList.remove('bg-slate-700');
    element.classList.add('border-b-2');
    element.classList.add('border-b-orange-500');
    select_ide_editor(element.getAttribute('data-file-order'));
}

window.get_file_lang = function(element){
    let file_name = element.innerText;
    let extension = file_name.split('.')[1];
    if(extension == undefined) return '';
    let lang = findId(extension.trim(),files.LanguageIcon);
    if(lang == undefined) return '';
    let lang_name = lang.icon.name;
    return lang_name;
}
window.add_file_icons_to_files = function(){
    var file_tabs = document.getElementsByClassName('file_tab');
    for(let i = 0; i<file_tabs.length; i++){
        let file_name = file_tabs[i].innerText;
        let extension = file_name.split('.')[1];

        if(extension !== undefined){
            let icon = findId(extension.trim(),files.LanguageIcon);
            if(icon == undefined) {
                if(file_tabs[i].querySelector('.icon'))
                file_tabs[i].querySelector('.icon').innerHTML = "";
                continue;
            }
            let icon_image = icon.icon.name;
            let img_element = document.createElement('img');
            img_element.src = "/icons/"+icon_image+".svg";
            img_element.setAttribute('class','w-full h-full object-contain')
            file_tabs[i].querySelector('.icon').innerHTML = "";
            file_tabs[i].querySelector('.icon').prepend(img_element);
        }else{
            if(file_tabs[i].querySelector('.icon'))
            file_tabs[i].querySelector('.icon').innerHTML = "";
        }
    }
}

window.remove_file_tabs_selection = function(){
    var file_tabs = document.getElementsByClassName('file_tab');
    for(let i = 0; i<file_tabs.length; i++){
        file_tabs[i].classList.remove('current_file_tab');
        file_tabs[i].classList.remove('bg-slate-800');
        file_tabs[i].classList.add('bg-slate-700');
        file_tabs[i].classList.remove('border-b-2');
        file_tabs[i].classList.remove('border-b-organge-500');
    }
}

window.add_file_action = function(){
    tab_file_orders++;
    let file_tab = document.querySelector('.file_tab');
    let file_tab_clone = file_tab.cloneNode(true);
    file_tab_clone.setAttribute('data-file-order',tab_file_orders);
    file_tab_clone.classList.remove('border-b-2');
    file_tab.parentElement.append(file_tab_clone);
    file_tab_clone.querySelector('img').remove();
    file_tab_clone.querySelector('.file_name').classList.add('opacity-0')
    file_tab_clone.querySelector('.file_name').innerHTML = "Enter file name";
    file_tab_clone.querySelector('input').value="";
    file_tab_clone.querySelector('input').placeholder="Enter name";
    file_tab_clone.querySelector('input').classList.remove('hidden');
    file_tab_clone.querySelector('input').focus();
    let remove_file_button = document.createElement('div');
    remove_file_button.setAttribute('class','remove_file text-slate-500 hover:text-slate-300');
    remove_file_button.innerHTML = "<i class='las la-times ml-2'></i>";
    file_tab_clone.appendChild(remove_file_button);
    edit_file_tab_names();
}
window.add_file_button = function(){
    var add_file_button = document.getElementById('add_file_button');
    add_file_button.addEventListener('click',function(){
        add_file_action();
    });
}
window.edit_ide_editor_mode = function(lang,file_order){
    var a_ace_editor = ace.edit("editor-"+file_order);
    if(lang == 'html')
        a_ace_editor.session.setMode("ace/mode/html");
    else if(lang == 'cpp' || lang == "c")
        a_ace_editor.session.setMode("ace/mode/c_cpp");
    else if(lang == 'java')
        a_ace_editor.session.setMode("ace/mode/java");
    else if(lang == 'php')
        a_ace_editor.session.setMode("ace/mode/php");
    else if(lang == 'css')
        a_ace_editor.session.setMode("ace/mode/css");
    else if(lang == 'python')
        a_ace_editor.session.setMode("ace/mode/python");

    else
        a_ace_editor.session.setMode("");
}
window.select_ide_editor = function(file_order){
    var a_ace_editors = document.getElementsByClassName('ace_file_editor');
    var parent_editor = document.getElementById('editor');
    for(let i = 0; i < a_ace_editors.length; i ++ ){
        a_ace_editors[i].style.fontSize = parent_editor.style.fontSize;
        a_ace_editors[i].classList.add('hidden');
    }
    if(document.getElementById('editor-'+file_order))
    document.getElementById('editor-'+file_order).classList.remove('hidden');
}

window.get_ide_editors_values = function(){
    var a_ace_editors = document.getElementsByClassName('ace_file_editor');
    var editor_values= [];
    for(let i = 0; i < a_ace_editors.length; i ++ ){
        let editor_id = a_ace_editors[i].getAttribute('id');
        var a_ace_editor = ace.edit(editor_id);
        editor_values.push([document.querySelector("div[data-file-order='"+editor_id.split('-')[1]+"']").innerText,a_ace_editor.getSession().getValue()]);
    }
    return editor_values;
}
window.get_ide_editor_ids = function(){
    var a_ace_editors = document.getElementsByClassName('ace_file_editor');
    var editor_ids= [];
    for(let i = 0; i < a_ace_editors.length; i ++ ){
        let editor_id = a_ace_editors[i].getAttribute('id');
        editor_ids.push(editor_id);
    }
    return editor_ids;
}
window.remove_ide_editor = function(file_order){
    document.getElementById('editor-'+file_order).remove();
    document.getElementById('editor-input-'+file_order).remove();
}
window.add_ide_editor = function(lang,file_order){
    var a_ace_editors = document.getElementsByClassName('ace_file_editor');
    for(let i = 0; i < a_ace_editors.length; i ++ ){
        a_ace_editors[i].classList.add('hidden');
    }
    var new_editor = document.createElement('div');
    var new_editor_input = document.createElement('input');
    new_editor.setAttribute('class','ace_file_editor w-full h-full');
    new_editor.setAttribute('id','editor-'+file_order);
    document.getElementById('editor').append(new_editor);

    new_editor_input.setAttribute('type',"hidden");
    new_editor_input.setAttribute('name',"base_skeleton_file[]");
    new_editor_input.setAttribute('id','editor-input-'+file_order);
    document.getElementById('editor').append(new_editor_input);
    
    a_ace_editor = ace.edit("editor-"+file_order);
    a_ace_editor.setTheme("ace/theme/monokai");
    edit_ide_editor_mode(lang,file_order);
    a_ace_editor.setOptions({
        enableBasicAutocompletion: true,
        enableSnippets: true,
        enableLiveAutocompletion: true
    });
    a_ace_editor.focus();
}
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
    add_file_icons_to_files();
    edit_file_tab_names();
    add_file_button();
});

window.keyboardListener = [];
// Online IDE Keyboard shortcuts
window.editor_keyboard_shortcuts = function(e,element,event_type){

    if(event_type == 0 && e.keyCode != 18){ //Key Down
        keyboardListener.push(e.keyCode);
    }else{
        keyboardListener = keyboardListener.filter(x => x !== e.keyCode);
        return;
    }
    e = e || window.event;
    var code = e.keyCode;
    console.log(keyboardListener[0], keyboardListener[1]);
    if(keyboardListener[0] == 17 && keyboardListener[1] == 187){
        e.preventDefault();
        if(parseInt(replace(element.style.fontSize,"px","")) > 30){
            return;
        }
        if(element.style.fontSize.length == 0){
            element.style.fontSize="18px";
        }
        element.style.fontSize = (parseInt(replace(element.style.fontSize,"px",""))+1) + "px";

         var a_ace_editors = document.getElementsByClassName('ace_file_editor');
        for(let i = 0; i < a_ace_editors.length; i ++ ){
            a_ace_editors[i].style.fontSize = element.style.fontSize;
        }
        keyboardListener = [17];
    }
    else if(keyboardListener[0] == 17 && keyboardListener[1] == 189){
        e.preventDefault();
        if(parseInt(replace(element.style.fontSize,"px","")) < 5){
            return;
        }
        if(element.style.fontSize.length == 0){
            element.style.fontSize="18px";
        }
        element.style.fontSize = (parseInt(replace(element.style.fontSize,"px",""))-1) + "px";
        var a_ace_editors = document.getElementsByClassName('ace_file_editor');
        for(let i = 0; i < a_ace_editors.length; i ++ ){
            a_ace_editors[i].style.fontSize = element.style.fontSize;
        }
        keyboardListener = [17];
    }
    else if(keyboardListener[0] == 17 && keyboardListener[1] == 79 ){
        e.preventDefault();
        console.log('x');
        add_file_action();
        keyboardListener = [];
    }else if(keyboardListener[0] == 17 && keyboardListener[1] == 81 ){
        e.preventDefault();
        let current_tab = document.querySelector('.current_file_tab');
        if(current_tab.querySelector('.remove_file '))
            current_tab.querySelector('.remove_file ').dispatchEvent( new MouseEvent( 'click' ) );
        keyboardListener = [];
    }
    
    console.log(code, element);
}
window.tips_array = [];
window.current_tip = 0;
window.tip_cookie = null;
window.tour = function(element){
    tip_cookie = element.getAttribute('data-cookie');
    if(!tip_cookie) tip_cookie = null;    
    var tips = element.querySelectorAll('li');
    for(let i = 0; i <tips.length; i++){

        let container = document.getElementById(tips[i].getAttribute('data-id'));
        if(container == undefined) continue;
        tips_array.push([tips[i].getAttribute('data-id'),tips[i].innerHTML,tips[i].getAttribute('data-position')]);
    }
    for(let i = 0; i <tips_array.length; i++){
        let data_id = tips_array[i][0];
        let content = tips_array[i][1];
        let position = tips_array[i][2];
        let container = document.getElementById(data_id);
        let tip = document.createElement('div');
        tip.classList.add('tip');
        tip.classList.add('absolute');
        if(position){
            tip.classList.add(position);
        }else{
            tip.classList.add('top-full');
        }
        tip.classList.add('left-0');
        tip.classList.add('hidden');
        tip.classList.add('py-4');
        tip.classList.add('px-8');
        tip.classList.add('pb-24');
        tip.setAttribute('style','--tw-bg-opacity:0.8');
        tip.style.minHeight = "100px";
        tip.classList.add('bg-white');
        tip.classList.add('shadow-lg');
        tip.classList.add('rounded-md');
        tip.classList.add('border');
        tip.classList.add('border-orange-500');
        var tip_arrow = document.createElement('div');
        tip_arrow.classList.add('w-0');
        tip_arrow.classList.add('h-0');
        tip_arrow.classList.add('border-8');
        
        tip_arrow.classList.add('absolute');
        var tip_arrow_position = "bottom";
        if(position){
            if(position.split('-')[0] == "bottom"){
                tip_arrow_position = "top"
            }
        }
        tip_arrow.classList.add(tip_arrow_position+'-full');
        if(tip_arrow_position == "bottom"){
            tip_arrow.classList.add('border-t-transparent');
            tip_arrow.classList.add('border-r-transparent');
            tip_arrow.classList.add('border-l-transparent');
            tip_arrow.classList.add('border-b-orange-500');
            tip_arrow.classList.add('mt-1');
        }else{
            tip_arrow.classList.add('border-b-transparent');
            tip_arrow.classList.add('border-r-transparent');
            tip_arrow.classList.add('border-l-transparent');
            tip_arrow.classList.add('border-t-orange-500');
            tip_arrow.classList.add('mb-1');
        }

        tip_arrow.classList.add('left-4');
        var tip_button = document.createElement('div');
        tip_button.classList.add('px-4');
        tip_button.classList.add('py-2');
        tip_button.classList.add('bg-orange-500');
        tip_button.classList.add('hover:bg-orange-700');
        tip_button.classList.add('cursor-pointer');
        tip_button.classList.add('text-white');
        tip_button.classList.add('absolute');
        tip_button.classList.add('bottom-4');
        tip_button.classList.add('left-8');
        if(tips_array[i+1]){
            var tip_button_content = "Next";
        }else{
            var tip_button_content = "Finish";
        }
        tip_button.innerHTML = tip_button_content;
        tip.innerHTML = content;
        tip.appendChild(tip_arrow);
        tip.appendChild(tip_button);
        tip_button.addEventListener('click',function(){
            next_tip();
        });
        container.append(tip);
        tips_array[i].push(tip);
    }
    console.log(tips_array);
}

window.start_tour = function(){
    //Check if tour is in cookies to not run it again if runned before
    if(tip_cookie != null){
        var check_cookie = getCookie(tip_cookie);
        if(check_cookie) return;
    }
    current_tip = 0;
    for(let i = 0; i <tips_array.length; i++){
        tips_array[i][3].classList.add('hidden');
    }
    tips_array[current_tip][3].classList.remove('hidden');
    if(!isInViewport(tips_array[current_tip][3]))
        tips_array[current_tip][3].scrollIntoView({ behavior: 'smooth',block: "center" });
}

window.next_tip = function(){
    tips_array[current_tip][3].classList.add('hidden');
    current_tip++;
    if(tips_array[current_tip]){
        tips_array[current_tip][3].classList.remove('hidden');
        if(!isInViewport(tips_array[current_tip][3]))
            tips_array[current_tip][3].scrollIntoView({ behavior: 'smooth',block: "center" });
    }else if(tip_cookie != null){
        //Tour ended, add it to cookies to not display it again
        document.cookie = tip_cookie+"=true";
    }
}
window.getCookie = function(name) {
  let matches = document.cookie.match(new RegExp(
    "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
  ));
  return matches ? decodeURIComponent(matches[1]) : undefined;
}
window.isInViewport = function(element){
    const rect = element.getBoundingClientRect();
    const isInViewport = rect.top >= 0 &&
            rect.left >= 0 &&
            rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
            rect.right <= (window.innerWidth || document.documentElement.clientWidth);
    return isInViewport;
}
