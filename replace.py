import re

with open('app/Views/home.html', 'r', encoding='utf-8') as f:
    content = f.read()

new_section = '''<!-- Section 1: Holland Codes -->
            <section class="bg-white py-24 px-4 md:px-8">
                <div class="max-w-[1200px] mx-auto">
                    
                    <!-- Header -->
                    <div class="text-center max-w-3xl mx-auto mb-16">
                        <h2 class="text-emerald-600 font-bold text-sm tracking-widest uppercase mb-3">The Science of Matching</h2>
                        <h3 class="text-3xl md:text-5xl font-serif-heading font-bold text-gray-900 mb-6 leading-tight">Discover Your Holland Code</h3>
                        <p class="text-gray-600 text-base md:text-lg leading-relaxed mb-8">
                            The RIASEC model breaks down personalities into six distinct career types. By understanding your unique code, you unlock the secret to finding a career that naturally fits your strengths and interests.
                        </p>
                        <a href="holland" class="inline-flex items-center gap-2 text-white bg-emerald-700 hover:bg-emerald-800 font-bold py-3.5 px-8 rounded-full transition shadow-lg hover:shadow-xl hover:-translate-y-0.5">
                            Read about the 6 types
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                    </div>

                    <!-- 3x2 Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
                        
                        <!-- Realistic -->
                        <div class="group bg-white p-8 rounded-[2rem] border border-gray-100 shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 relative overflow-hidden">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-rose-50 rounded-bl-full -mr-8 -mt-8 transition-transform group-hover:scale-110"></div>
                            <div class="relative z-10 flex items-start gap-5">
                                <div class="w-14 h-14 bg-rose-100 text-rose-600 rounded-2xl flex items-center justify-center flex-shrink-0 group-hover:rotate-12 transition-transform">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900 text-xl mb-1">Realistic</h4>
                                    <p class="text-rose-600 font-semibold text-sm mb-3 tracking-wide uppercase">The Doers</p>
                                    <p class="text-gray-500 text-sm leading-relaxed">Practical, hands-on, and tool-oriented. They prefer working with things rather than people.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Investigative -->
                        <div class="group bg-white p-8 rounded-[2rem] border border-gray-100 shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 relative overflow-hidden">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-blue-50 rounded-bl-full -mr-8 -mt-8 transition-transform group-hover:scale-110"></div>
                            <div class="relative z-10 flex items-start gap-5">
                                <div class="w-14 h-14 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center flex-shrink-0 group-hover:rotate-12 transition-transform">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900 text-xl mb-1">Investigative</h4>
                                    <p class="text-blue-600 font-semibold text-sm mb-3 tracking-wide uppercase">The Thinkers</p>
                                    <p class="text-gray-500 text-sm leading-relaxed">Analytical, intellectual, and scientific. They love solving complex problems through research.</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Artistic -->
                        <div class="group bg-white p-8 rounded-[2rem] border border-gray-100 shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 relative overflow-hidden">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-purple-50 rounded-bl-full -mr-8 -mt-8 transition-transform group-hover:scale-110"></div>
                            <div class="relative z-10 flex items-start gap-5">
                                <div class="w-14 h-14 bg-purple-100 text-purple-600 rounded-2xl flex items-center justify-center flex-shrink-0 group-hover:rotate-12 transition-transform">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path></svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900 text-xl mb-1">Artistic</h4>
                                    <p class="text-purple-600 font-semibold text-sm mb-3 tracking-wide uppercase">The Creators</p>
                                    <p class="text-gray-500 text-sm leading-relaxed">Creative, original, and expressive. They thrive in environments where they can design and innovate.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Social -->
                        <div class="group bg-white p-8 rounded-[2rem] border border-gray-100 shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 relative overflow-hidden">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-50 rounded-bl-full -mr-8 -mt-8 transition-transform group-hover:scale-110"></div>
                            <div class="relative z-10 flex items-start gap-5">
                                <div class="w-14 h-14 bg-emerald-100 text-emerald-600 rounded-2xl flex items-center justify-center flex-shrink-0 group-hover:rotate-12 transition-transform">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900 text-xl mb-1">Social</h4>
                                    <p class="text-emerald-600 font-semibold text-sm mb-3 tracking-wide uppercase">The Helpers</p>
                                    <p class="text-gray-500 text-sm leading-relaxed">Empathetic, friendly, and cooperative. They find fulfillment in teaching, healing, and guiding others.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Enterprising -->
                        <div class="group bg-white p-8 rounded-[2rem] border border-gray-100 shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 relative overflow-hidden">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-orange-50 rounded-bl-full -mr-8 -mt-8 transition-transform group-hover:scale-110"></div>
                            <div class="relative z-10 flex items-start gap-5">
                                <div class="w-14 h-14 bg-orange-100 text-orange-600 rounded-2xl flex items-center justify-center flex-shrink-0 group-hover:rotate-12 transition-transform">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900 text-xl mb-1">Enterprising</h4>
                                    <p class="text-orange-600 font-semibold text-sm mb-3 tracking-wide uppercase">The Persuaders</p>
                                    <p class="text-gray-500 text-sm leading-relaxed">Ambitious, outgoing, and energetic. They excel in leadership, sales, and managing teams.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Conventional -->
                        <div class="group bg-white p-8 rounded-[2rem] border border-gray-100 shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 relative overflow-hidden">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-slate-50 rounded-bl-full -mr-8 -mt-8 transition-transform group-hover:scale-110"></div>
                            <div class="relative z-10 flex items-start gap-5">
                                <div class="w-14 h-14 bg-slate-100 text-slate-600 rounded-2xl flex items-center justify-center flex-shrink-0 group-hover:rotate-12 transition-transform">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900 text-xl mb-1">Conventional</h4>
                                    <p class="text-slate-600 font-semibold text-sm mb-3 tracking-wide uppercase">The Organizers</p>
                                    <p class="text-gray-500 text-sm leading-relaxed">Detail-oriented, systematic, and efficient. They are highly organized and work well with data.</p>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </section>

'''

start_idx = content.find("<!-- Section 1: Holland Codes -->")
end_idx = content.find("<!-- Section 2: Colleges -->")
new_full_content = content[:start_idx] + new_section + content[end_idx:]

with open('app/Views/home.html', 'w', encoding='utf-8') as f:
    f.write(new_full_content)
