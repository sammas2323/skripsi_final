<footer class="bg-white border-t py-6 w-full" x-data="{ open: false }">
    <div class="max-w-7xl mx-auto px-4 text-center text-sm text-gray-600">
        © {{ date('Y') }} Kontrakan Tony. All rights reserved.

        <div class="mt-2">
            <button 
                @click="open = true"
                class="text-indigo-600 hover:underline"
            >
                Terms & Privacy
            </button>
        </div>

        <!-- Modal -->
        <div 
            x-show="open"
            x-transition
            class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
        >
            <div class="bg-white rounded-lg shadow-lg max-w-2xl w-full p-6 relative">
                <h2 class="text-xl font-bold mb-4 text-gray-800">Terms & Privacy</h2>

                <div class="max-h-96 overflow-y-auto text-gray-600 text-sm space-y-4 text-left">
                    <p>
                        Dengan menggunakan layanan KontrakanTony, Anda setuju untuk menggunakan aplikasi secara bertanggung jawab dan tidak melanggar hukum yang berlaku.
                    </p>
                    <p>
                        Kami tidak bertanggung jawab atas kerugian akibat kelalaian pengguna.
                    </p>
                    <p>
                        KontrakanTony dapat mengubah syarat dan ketentuan kapan saja tanpa pemberitahuan.
                    </p>
                    <p>
                        Silakan baca:
                        <ul class="list-disc pl-5 mt-2 space-y-1">
                            <li>
                                <a href="{{ url('/terms-of-service') }}" target="_blank" class="text-indigo-600 hover:underline">
                                    Terms of Service
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('/privacy-policy') }}" target="_blank" class="text-indigo-600 hover:underline">
                                    Privacy Policy
                                </a>
                            </li>
                        </ul>
                    </p>
                    <p>
                        Hubungi kami di <strong>ysam0671@gmail.com</strong> jika ada pertanyaan.
                    </p>
                </div>

                <!-- Tombol close -->
                <button 
                    @click="open = false"
                    class="absolute top-3 right-3 text-gray-500 hover:text-gray-800"
                >
                    ✕
                </button>
            </div>
        </div>
    </div>
</footer>
