<?php if (!defined('ABSPATH')) exit; ?>

<div id="modal" class="fixed inset-0 flex items-center justify-center bg-zinc-900/60 backdrop-blur-sm z-50 p-4 close">

    <div class="modal max-w-[500px] w-full rounded-2xl bg-white dark:bg-zinc-950 shadow-2xl border border-zinc-200 dark:border-zinc-800 overflow-hidden">

        <div class="modal__head p-8 pb-4 text-left relative">
            <h2 class="text-3xl font-semibold tracking-tight text-zinc-900 dark:text-zinc-50">Sign in</h2>
            <p class="text-zinc-500 dark:text-zinc-400 mt-2 text-sm">Welcome back! Please enter your details.</p>

            <button id="closeSignInModal" class="absolute top-8 right-8 text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-100 transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div class="modal__content p-8 pt-2 flex flex-col gap-5">

            <ul class="flex gap-6 mb-2 border-b-2 border-zinc-100 dark:border-zinc-800">
                <li>
                    <a href="#"
                    data-tab="login"
                    class="tab__link inline-block pb-3 text-sm font-semibold  dark:border-zinc-100 text-zinc-900 dark:text-zinc-100">
                        Log In
                    </a>
                </li>

                <li>
                    <a href="#"
                    data-tab="register"
                    class="tab__link inline-block pb-3 text-sm font-medium text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-300 transition-colors">
                        Register
                    </a>
                </li>
            </ul>

            <div class="tab tab--login">
                <form action="" method="POST" class="form form-login flex flex-col gap-5">
                    <!-- Username -->
                    <div class="relative group">
                        <div class="absolute left-4 top-1/2 -translate-y-1/2 text-zinc-400 group-focus-within:text-zinc-900 dark:group-focus-within:text-zinc-100 transition-colors">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                        </div>
                        <input 
                            type="text" 
                            name="username"
                            placeholder="Username/Email"
                            class="w-full pl-11 pr-4 py-3.5 rounded-xl border border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-900/50 text-zinc-900 dark:text-zinc-100 placeholder:text-zinc-400 focus:outline-none focus:ring-2 focus:ring-zinc-900/5 dark:focus:ring-zinc-100/5 focus:border-zinc-900 dark:focus:border-zinc-100 transition-all"
                        >
                    </div>

                    <!-- Password -->
                    <div class="relative group password-field">
                        
                        <!-- Icon left -->
                        <div class="absolute left-4 top-1/2 -translate-y-1/2 text-zinc-400 
                                    group-focus-within:text-zinc-900 
                                    dark:group-focus-within:text-zinc-100 transition-colors">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="11" width="18" height="11" rx="2"></rect>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                            </svg>
                        </div>

                        <!-- Input -->
                        <input 
                            type="password" 
                            name="password"
                            placeholder="Password"
                            class="password-input w-full pl-11 pr-12 py-3.5 rounded-xl 
                                border border-zinc-200 dark:border-zinc-800 
                                bg-zinc-50 dark:bg-zinc-900/50 
                                text-zinc-900 dark:text-zinc-100 
                                placeholder:text-zinc-400 
                                focus:outline-none focus:ring-2 
                                focus:ring-zinc-900/5 dark:focus:ring-zinc-100/5 
                                focus:border-zinc-900 dark:focus:border-zinc-100 
                                transition-all"
                        >

                        <!-- Toggle button -->
                        <button type="button"
                            class="toggle-password absolute right-4 top-1/2 -translate-y-1/2 
                                text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-100">

                            <!-- Show -->
                            <svg class="show-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                                <line x1="1" y1="1" x2="23" y2="23"></line>
                            </svg>

                            <!-- Hide -->
                            <svg class="hide-icon hidden" xmlns="http://www.w3.org/2000/svg"
                                width="18" height="18" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5
                                        c4.478 0 8.268 2.943 9.542 7
                                        -1.274 4.057-5.064 7-9.542 7
                                        -4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>

                        </button>
                    </div>

                    <a href="/forgot-password" class="text-xs text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-100 underline underline-offset-4">
                        Lost Your Password?
                    </a>

                    <label class="flex items-center gap-3 cursor-pointer group w-fit">
                        <div class="relative flex items-center justify-center">
                            <input 
                                type="checkbox" 
                                name="rememberMe" 
                                class="peer h-5 w-5 cursor-pointer appearance-none rounded-md border border-zinc-300 dark:border-zinc-700 bg-transparent transition-all checked:bg-zinc-900 dark:checked:bg-zinc-100 checked:border-zinc-900 dark:checked:border-zinc-100"
                            />
                            <svg 
                                class="pointer-events-none absolute top-1/2 left-1/2 h-3.5 w-3.5 -translate-x-1/2 -translate-y-1/2 opacity-0 peer-checked:opacity-100 stroke-white dark:stroke-zinc-900" 
                                xmlns="http://www.w3.org/2000/svg" 
                                fill="none" 
                                viewBox="0 0 24 24" 
                                stroke-width="4"
                            >
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                            </svg>
                        </div>

                        <span class="text-sm text-zinc-600 dark:text-zinc-400 group-hover:text-zinc-900 dark:group-hover:text-zinc-100 transition-colors">
                            Remember Me
                        </span>
                    </label>

                    <div class="pt-2">
                        <button type="submit" class="w-full md:w-auto py-3 px-12 rounded-xl bg-zinc-900 dark:bg-zinc-100 text-white dark:text-zinc-900 font-semibold hover:bg-zinc-800 dark:hover:bg-white transition-all shadow-lg shadow-zinc-200 dark:shadow-none active:scale-[0.98]">
                            Login
                        </button>
                    </div>
                </form>
            </div>
            <div class="tab tab--register">
                <form action="" method="POST" class="form form-register flex flex-col gap-5">
                    <!-- Username -->
                    <div class="relative group">
                        <div class="absolute left-4 top-1/2 -translate-y-1/2 text-zinc-400 group-focus-within:text-zinc-900 dark:group-focus-within:text-zinc-100 transition-colors">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                        </div>
                        <input 
                            type="text" 
                            name="username"
                            placeholder="Username"
                            class="w-full pl-11 pr-4 py-3.5 rounded-xl border border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-900/50 text-zinc-900 dark:text-zinc-100 placeholder:text-zinc-400 focus:outline-none focus:ring-2 focus:ring-zinc-900/5 dark:focus:ring-zinc-100/5 focus:border-zinc-900 dark:focus:border-zinc-100 transition-all"
                        >
                    </div>
                    <!-- Email -->
                    <div class="relative group">
                        <div class="absolute left-4 top-1/2 -translate-y-1/2 text-zinc-400 group-focus-within:text-zinc-900 dark:group-focus-within:text-zinc-100 transition-colors">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 7.00005L10.2426 12.2022C11.2426 13.0355 12.7574 13.0355 13.7574 12.2022L20 7.00005" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <rect x="3" y="5" width="18" height="14" rx="3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                            </svg>

                        </div>
                        <input 
                            type="text" 
                            name="email"
                            placeholder="Email Adress"
                            class="w-full pl-11 pr-4 py-3.5 rounded-xl border border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-900/50 text-zinc-900 dark:text-zinc-100 placeholder:text-zinc-400 focus:outline-none focus:ring-2 focus:ring-zinc-900/5 dark:focus:ring-zinc-100/5 focus:border-zinc-900 dark:focus:border-zinc-100 transition-all"
                        >
                    </div>

                    <!-- Password -->
                    <div class="relative group password-field">
                        
                        <!-- Icon left -->
                        <div class="absolute left-4 top-1/2 -translate-y-1/2 text-zinc-400 
                                    group-focus-within:text-zinc-900 
                                    dark:group-focus-within:text-zinc-100 transition-colors">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="11" width="18" height="11" rx="2"></rect>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                            </svg>
                        </div>

                        <!-- Input -->
                        <input 
                            type="password" 
                            name="password"
                            placeholder="Password"
                            class="password-input w-full pl-11 pr-12 py-3.5 rounded-xl 
                                border border-zinc-200 dark:border-zinc-800 
                                bg-zinc-50 dark:bg-zinc-900/50 
                                text-zinc-900 dark:text-zinc-100 
                                placeholder:text-zinc-400 
                                focus:outline-none focus:ring-2 
                                focus:ring-zinc-900/5 dark:focus:ring-zinc-100/5 
                                focus:border-zinc-900 dark:focus:border-zinc-100 
                                transition-all"
                        >

                        <!-- Toggle button -->
                        <button type="button" class="toggle-password absolute right-4 top-1/2 -translate-y-1/2 text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-100">

                            <!-- Show -->
                            <svg class="show-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                                <line x1="1" y1="1" x2="23" y2="23"></line>
                            </svg>

                            <!-- Hide -->
                            <svg class="hide-icon hidden" xmlns="http://www.w3.org/2000/svg"
                                width="18" height="18" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5
                                        c4.478 0 8.268 2.943 9.542 7
                                        -1.274 4.057-5.064 7-9.542 7
                                        -4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>

                        </button>
                    </div>

                    <label class="flex items-center gap-3 cursor-pointer w-fit">
                        <div class="relative flex items-center justify-center">
                            <input 
                                type="checkbox" 
                                name="agreeToTermsAndConditions"
                                class="peer h-5 w-5 cursor-pointer appearance-none rounded-md border border-zinc-300 dark:border-zinc-700 bg-transparent transition-all checked:bg-zinc-900 dark:checked:bg-zinc-100 checked:border-zinc-900 dark:checked:border-zinc-100"
                            />
                            <svg 
                                class="pointer-events-none absolute top-1/2 left-1/2 h-3.5 w-3.5 -translate-x-1/2 -translate-y-1/2 opacity-0 peer-checked:opacity-100 stroke-white dark:stroke-zinc-900" 
                                xmlns="http://www.w3.org/2000/svg" 
                                fill="none" 
                                viewBox="0 0 24 24" 
                                stroke-width="4"
                            >
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                            </svg>
                        </div>

                        <span class="text-sm text-zinc-600 dark:text-zinc-400 transition-colors">
                            I agree to the 
                            <a class="text-blue-500 hover:text-zinc-600 dark:hover:text-zinc-400">
                                Terms and Conditions
                            </a>
                        </span>
                    </label>

                    <div class="pt-2">
                        <button type="submit" class="w-full md:w-auto py-3 px-12 rounded-xl bg-zinc-900 dark:bg-zinc-100 text-white dark:text-zinc-900 font-semibold hover:bg-zinc-800 dark:hover:bg-white transition-all shadow-lg shadow-zinc-200 dark:shadow-none active:scale-[0.98]">
                            Register
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>