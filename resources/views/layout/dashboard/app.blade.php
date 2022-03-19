@php
    $page = app()->view->getSections()['page'] ?? null;
    $page = rtrim($page);
@endphp
<!DOCTYPE html>
<html :class="{ 'dark': dark }" x-data="data()" lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title')</title>
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
    <script
      src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js"
      defer
    ></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script src="{{ asset('js/init-alpine.js') }}"></script>
  </head>
  <body>
    <div
      class="flex h-screen bg-gray-50 dark:bg-gray-900"
      :class="{ 'overflow-hidden': isSideMenuOpen}"
    >
<!-- Desktop sidebar -->
<aside
        class="z-20 hidden w-64 overflow-y-auto bg-white dark:bg-gray-800 md:block flex-shrink-0"
      >
        <x-dashboard-navigator/>
      </aside>

      
      <!-- Mobile sidebar -->
      <!-- Backdrop -->
      <div
        x-show="isSideMenuOpen"
        x-transition:enter="transition ease-in-out duration-150"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in-out duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-10 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center"
      ></div>
      <aside
        class="fixed inset-y-0 z-20 flex-shrink-0 w-64 mt-16 overflow-y-auto bg-white dark:bg-gray-800 md:hidden"
        x-show="isSideMenuOpen"
        x-transition:enter="transition ease-in-out duration-150"
        x-transition:enter-start="opacity-0 transform -translate-x-20"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in-out duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0 transform -translate-x-20"
        @click.away="closeSideMenu"
        @keydown.escape="closeSideMenu"
      >
        <x-dashboard-navigator :page="$page" />
      </aside>
      <div class="flex flex-col flex-1">
      <header class="z-10 py-4 bg-white shadow-md dark:bg-gray-800">
          <div
            class="container flex items-center justify-between h-full px-6 mx-auto text-orange-600 dark:text-orange-300"
          >
            <!-- Mobile hamburger -->
            <button
              class="p-1 -ml-1 mr-5 rounded-md md:hidden focus:outline-none focus:shadow-outline-orange"
              @click="toggleSideMenu"
              aria-label="Menu"
            >
              <svg
                class="w-6 h-6"
                aria-hidden="true"
                fill="currentColor"
                viewBox="0 0 20 20"
              >
                <path
                  fill-rule="evenodd"
                  d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                  clip-rule="evenodd"
                ></path>
              </svg>
            </button>
            <!-- Search input -->
            <div class="flex justify-center flex-1 lg:mr-32">
              <div
                class="relative w-full max-w-xl mr-6 focus-within:text-orange-500"
              >
                <div class="absolute inset-y-0 flex items-center pl-2">
                  <svg
                    class="w-4 h-4"
                    aria-hidden="true"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                  >
                    <path
                      fill-rule="evenodd"
                      d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                      clip-rule="evenodd"
                    ></path>
                  </svg>
                </div>
                <input
                  id="search_input"
                  class="w-full pl-8 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-0 rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-orange-300 focus:outline-none focus:shadow-outline-orange form-input"
                  type="text"
                  placeholder="Search here"
                  aria-label="Search"
                />
                <div id="search_dropdown" class="absolute top-full w-full py-2 bg-white dark:bg-gray-800 shadow-sm px-4">
                    
                    <div id="code_search_container"></div>
                    <div id="person_search_container"></div>
                    <div id="email_search_container"></div>
                    <div id="phone_search_container"></div>
                    <div id="slot_search_container"></div>
                    <div class="hidden" id="search_element_cloner">
                        <a class="element block py-2 px-4 text-gray-500 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600 cursor-pointer">
                            
                        </a>
                    </div>
                    
                </div>
                <script>
                    var search_input = document.getElementById('search_input');
                    var search_cloner = document.getElementById('search_element_cloner');
                    var search_persons_container = document.getElementById('person_search_container');
                    var search_emails_container = document.getElementById('email_search_container');
                    var search_phones_container = document.getElementById('phone_search_container');
                    var search_codes_container = document.getElementById('code_search_container');
                    var search_slots_container = document.getElementById('slot_search_container');
                    var search_dropdown = document.getElementById('search_dropdown');
                    search_input.addEventListener('focus',function(){
                      search_dropdown.classList.remove('hidden');
                    });

                    search_input.addEventListener('input',function(){
                    if(this.value.length == 0){
                      search_dropdown.classList.add('hidden');
                      return;
                    }
                    search_dropdown.classList.remove('hidden');
                    
                    var self = this;
                    var xhttp = new XMLHttpRequest();
                    xhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            search_persons_container.innerHTML = "";
                            search_emails_container.innerHTML = "";
                            search_codes_container.innerHTML = "";
                            search_phones_container.innerHTML = "";
                            search_slots_container.innerHTML = "";
                            var data = JSON.parse(xhttp.responseText);
                            var persons = data.name;
                            var emails = data.email;
                            var phones = data.phone;
                            var codes = data.code;
                            if(persons){
                                for(let i = 0; i<persons.length; i++){
                                    var element = search_cloner.querySelector('a').cloneNode(true);
                                    element.setAttribute("href","/belonging/"+persons[i].id);
                                    element.innerHTML = persons[i].name.toLowerCase().replace(self.value.toLowerCase(),`<span class='font-bold text-black dark:text-white'>${self.value}</span>`);
                                    element.innerHTML += " | " + persons[i].phone;
                                    element.innerHTML += " | " + persons[i].type.name;
                                    element.innerHTML += " | " + persons[i].code;
                                    search_persons_container.appendChild(element);
                                }
                            }
                            if(emails){
                                for(let i = 0; i<emails.length; i++){
                                    var element = search_cloner.querySelector('a').cloneNode(true);
                                    element.setAttribute("href","/belonging/"+emails[i].id);
                                    element.innerHTML = emails[i].email.toLowerCase().replace(self.value.toLowerCase(),`<span class='font-bold text-black dark:text-white'>${self.value}</span>`);
                                    element.innerHTML += " | " + emails[i].name;
                                    element.innerHTML += " | " + emails[i].type.name;
                                    element.innerHTML += " | " + emails[i].code;
                                    search_emails_container.appendChild(element);
                                }
                            }
                            if(phones){
                                for(let i = 0; i<phones.length; i++){
                                    var element = search_cloner.querySelector('a').cloneNode(true);
                                    element.setAttribute("href","/belonging/"+phones[i].id);
                                    element.innerHTML =  phones[i].name; 
                                    element.innerHTML += " | " + phones[i].phone.replace(self.value,`<span class='font-bold text-black dark:text-white'>${self.value}</span>`);
                                    element.innerHTML += " | " + phones[i].type.name;
                                    element.innerHTML += " | " + phones[i].code;
                                    search_phones_container.appendChild(element);
                                }
                            }
                            if(codes){
                                for(let i = 0; i<codes.length; i++){
                                    var element = search_cloner.querySelector('a').cloneNode(true);
                                    element.setAttribute("href","/belonging/"+codes[i].id);
                                    element.innerHTML =  codes[i].name; 
                                    element.innerHTML += " | " + codes[i].code.replace(self.value,`<span class='font-bold text-black dark:text-white'>${self.value}</span>`);
                                    element.innerHTML += " | " + codes[i].type.name;
                                    element.innerHTML += " | " + codes[i].size.name;
                                    search_codes_container.appendChild(element);
                                }
                            }
                        }
                    };
                    xhttp.open("GET", "/api/search?q="+self.value, true);
                    xhttp.send();
                    });
                    document.body.addEventListener('click',function(e){
                      if(e.target != search_dropdown && e.target != search_input){
                        search_dropdown.classList.add('hidden');
                      }
                    });
                </script>
              </div>
            </div>
            <ul class="flex items-center flex-shrink-0 space-x-6">
              <!-- Theme toggler -->
              <li class="flex">
                <button
                  class="rounded-md focus:outline-none focus:shadow-outline-orange"
                  @click="toggleTheme"
                  aria-label="Toggle color mode"
                >
                  <template x-if="!dark">
                    <svg
                      class="w-5 h-5"
                      aria-hidden="true"
                      fill="currentColor"
                      viewBox="0 0 20 20"
                    >
                      <path
                        d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"
                      ></path>
                    </svg>
                  </template>
                  <template x-if="dark">
                    <svg
                      class="w-5 h-5"
                      aria-hidden="true"
                      fill="currentColor"
                      viewBox="0 0 20 20"
                    >
                      <path
                        fill-rule="evenodd"
                        d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
                        clip-rule="evenodd"
                      ></path>
                    </svg>
                  </template>
                </button>
              </li>
              <!-- Profile menu -->
              <li class="relative">
                <button
                  class="align-middle rounded-full focus:shadow-outline-orange focus:outline-none"
                  @click="toggleProfileMenu"
                  @keydown.escape="closeProfileMenu"
                  aria-label="Account"
                  aria-haspopup="true"
                >
                  <img
                    class="object-cover w-8 h-8 rounded-full border"
                    src="{{ asset('png/user.png') }}"
                    aria-hidden="true"
                  />
                </button>
                <template x-if="isProfileMenuOpen">
                  <ul
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    @click.away="closeProfileMenu"
                    @keydown.escape="closeProfileMenu"
                    class="absolute right-0 w-56 p-2 mt-2 space-y-2 text-gray-600 bg-white border border-gray-100 rounded-md shadow-md dark:border-gray-700 dark:text-gray-300 dark:bg-gray-700"
                    aria-label="submenu"
                  >
                    <li class="flex">
                      <a
                        class="inline-flex items-center w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200"
                        href="/logout"
                      >
                        <svg
                          class="w-4 h-4 mr-3"
                          aria-hidden="true"
                          fill="none"
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          viewBox="0 0 24 24"
                          stroke="currentColor"
                        >
                          <path
                            d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"
                          ></path>
                        </svg>
                        <span>Log out</span>
                      </a>
                    </li>
                  </ul>
                </template>
              </li>
            </ul>
          </div>
        </header>
        @yield('content')
      </div>
    </div>
  </body>
</html>
