import re

with open('app/Views/home.html', 'r', encoding='utf-8') as f:
    content = f.read()

new_sections = '''<!-- Section 2: Colleges -->
            <section class="bg-[#fdfaf6] py-24 px-4 md:px-8 border-t border-gray-100">
                <div class="max-w-[1200px] mx-auto">
                    <!-- Header -->
                    <div class="text-center max-w-3xl mx-auto mb-16">
                        <h2 class="text-orange-600 font-bold text-sm tracking-widest uppercase mb-3">Dasmariñas Campuses</h2>
                        <h3 class="text-3xl md:text-5xl font-serif-heading font-bold text-gray-900 mb-6 leading-tight">Find the Perfect Environment</h3>
                        <p class="text-gray-600 text-base md:text-lg leading-relaxed mb-8">
                            A great degree means nothing if the college environment doesn't suit you. We've profiled the top universities and colleges in Dasmariñas—both public and private—so you can find a campus culture that helps you thrive academically and socially.
                        </p>
                        <a href="colleges" class="inline-flex items-center gap-2 text-white bg-orange-600 hover:bg-orange-700 font-bold py-3.5 px-8 rounded-full transition shadow-lg hover:shadow-xl hover:-translate-y-0.5">
                            Browse 6 Premier Institutions
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                    </div>
                    
                    <!-- 3 Image Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="rounded-3xl overflow-hidden shadow-lg border border-gray-100 group relative h-64">
                            <img src="https://images.unsplash.com/photo-1607237138185-eedd9c632b0b?auto=format&fit=crop&w=600&q=80" alt="Campus" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent flex items-end p-6">
                                <h4 class="text-white font-bold text-xl">Private Sectarian</h4>
                            </div>
                        </div>
                        <div class="rounded-3xl overflow-hidden shadow-lg border border-gray-100 group relative h-64 md:-mt-8">
                            <img src="https://images.unsplash.com/photo-1541339907198-e08756dedf3f?auto=format&fit=crop&w=600&q=80" alt="Campus" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent flex items-end p-6">
                                <h4 class="text-white font-bold text-xl">State Universities</h4>
                            </div>
                        </div>
                        <div class="rounded-3xl overflow-hidden shadow-lg border border-gray-100 group relative h-64">
                            <img src="https://images.unsplash.com/photo-1562774053-701939374585?auto=format&fit=crop&w=600&q=80" alt="Campus" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent flex items-end p-6">
                                <h4 class="text-white font-bold text-xl">Technical Colleges</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Section 3: Degree Programs -->
            <section class="bg-white py-24 px-4 md:px-8 border-t border-gray-100">
                <div class="max-w-[1200px] mx-auto">
                    <!-- Header -->
                    <div class="text-center max-w-3xl mx-auto mb-16">
                        <h2 class="text-blue-600 font-bold text-sm tracking-widest uppercase mb-3">Academic Excellence</h2>
                        <h3 class="text-3xl md:text-5xl font-serif-heading font-bold text-gray-900 mb-6 leading-tight">Explore Degree Programs</h3>
                        <p class="text-gray-600 text-base md:text-lg leading-relaxed mb-8">
                            Stop guessing what course to take. Whether you belong in Engineering, Arts, Business, or IT, our platform categorizes every degree program by its RIASEC compatibility. Compare tuitions, program lengths, and discover exactly what you'll be studying.
                        </p>
                        <a href="degrees" class="inline-flex items-center gap-2 text-white bg-[#0e3223] hover:bg-black font-bold py-3.5 px-8 rounded-full transition shadow-lg hover:shadow-xl hover:-translate-y-0.5">
                            View All Programs
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                    </div>
                    
                    <!-- 3 Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-blue-50/50 p-8 rounded-[2rem] border border-blue-100 shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-300 group text-center">
                            <div class="w-16 h-16 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </div>
                            <h4 class="font-bold text-gray-900 text-xl mb-2">Computer Science & IT</h4>
                            <p class="text-blue-600 font-semibold text-xs tracking-wider uppercase mb-4">Investigative &bull; Conventional</p>
                            <p class="text-gray-500 text-sm">Software engineering, data science, networking, and information systems.</p>
                        </div>
                        <div class="bg-emerald-50/50 p-8 rounded-[2rem] border border-emerald-100 shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-300 group text-center md:-mt-8">
                            <div class="w-16 h-16 bg-emerald-100 text-emerald-600 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            </div>
                            <h4 class="font-bold text-gray-900 text-xl mb-2">Engineering & Architecture</h4>
                            <p class="text-emerald-600 font-semibold text-xs tracking-wider uppercase mb-4">Realistic &bull; Investigative</p>
                            <p class="text-gray-500 text-sm">Civil, mechanical, electrical engineering and architectural design.</p>
                        </div>
                        <div class="bg-orange-50/50 p-8 rounded-[2rem] border border-orange-100 shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-300 group text-center">
                            <div class="w-16 h-16 bg-orange-100 text-orange-600 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            </div>
                            <h4 class="font-bold text-gray-900 text-xl mb-2">Business & Management</h4>
                            <p class="text-orange-600 font-semibold text-xs tracking-wider uppercase mb-4">Enterprising &bull; Conventional</p>
                            <p class="text-gray-500 text-sm">Accounting, marketing, entrepreneurship, and human resources.</p>
                        </div>
                    </div>
                </div>
            </section>'''

start_idx = content.find("<!-- Section 2: Colleges -->")
new_full_content = content[:start_idx] + new_sections

with open('app/Views/home.html', 'w', encoding='utf-8') as f:
    f.write(new_full_content)
