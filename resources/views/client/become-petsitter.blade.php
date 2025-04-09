<x-layout-links>
    <section class="ftco-section bg-light ftco-faqs">
        <div class="container">
            <div class="mb-4">
                <a class="btn btn-white"
                    href="{{ route('dashboard') }}">
                    <i class="fa-solid fa-left"></i>
                    < back
                </a>
            </div>
            <div class="row">
                <div class="col-lg-6 order-md-last">
                    <div class="img img-video d-flex align-self-stretch align-items-center justify-content-center justify-content-md-center mb-4 mb-sm-0"
                        style="background-image:url(images/about.jpg);">
                        <a href="https://www.youtube.com/watch?v=_FAZ2PzjZ60"
                            class="icon-video popup-vimeo d-flex justify-content-center align-items-center">
                            <span class="fa fa-play"></span>
                        </a>
                    </div>
                    <div class="d-flex mt-3">
                        <div class="img img-2 mr-md-2" style="background-image:url(images/about-2.jpg);"></div>
                        <div class="img img-2 ml-md-2" style="background-image:url(images/about-3.jpg);"></div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="heading-section mb-5 mt-5 mt-lg-0">
                        <h2 class="mb-3">Voulez-vous devenir Pet Sitter ?</h2>
                        <p>Vous avez la possibilité de devenir Pet Sitter en quelques clics.
                            Vous devez ajouter votre pièce d'identité pour pouvoir devenir Pet Sitter.
                            Vous devez être majeur pour devenir Pet Sitter.
                            Vous devez être une personne physique.
                            Vous devez être une personne qui aime les animaux.
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, quos.
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, quos.
                        </p><br>
                        <p>Vous avez la possibilité de devenir Pet Sitter en quelques clics.
                            Vous devez ajouter votre pièce d'identité pour pouvoir devenir Pet Sitter.
                            Vous devez être majeur pour devenir Pet Sitter.
                            Vous devez être une personne physique.
                            Vous devez être une personne qui aime les animaux.
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, quos.
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, quos.
                        </p><br>
                        <p>Vous avez la possibilité de devenir Pet Sitter en quelques clics.
                            Vous devez ajouter votre pièce d'identité pour pouvoir devenir Pet Sitter.
                            Vous devez être majeur pour devenir Pet Sitter.
                            Vous devez être une personne physique.
                            Vous devez être une personne qui aime les animaux.
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, quos.
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, quos.
                        </p><br>
                    </div>
                    <div id="accordion" class="myaccordion w-100" aria-multiselectable="true">
                        <button
                            onclick="document.getElementById('popup-modal').classList.remove('hidden')"
                            class="btn btn-primary mb-5 mt-5 mt-lg-0 text-lg py-3"
                            style="color: white; transition: color 0.2s;"
                            onmouseover="this.style.color='#000000'"
                            onmouseout="this.style.color='white'">
                            Commencer
                        </button>

                        <div id="popup-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
                            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg w-full max-w-3xl relative">
                                <!-- Bouton close en haut -->
                                <button
                                    onclick="document.getElementById('popup-modal').classList.add('hidden')"
                                    class="absolute top-2 right-2 text-gray-500 hover:text-black text-2xl leading-none">
                                    &times;
                                </button>

                                <form action="" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('POST')

                                    <!-- Contenu -->
                                    <h2 class="text-2xl font-semibold mb-6 text-center">Devenir Pet Sitter</h2>

                                    <div class="mt-4">
                                        <x-input-label for="attestation" :value="__('Pièce d\'identité (recto/verso)')" />
                                        <input type="file" name="attestation"
                                            class="block mt-1 w-full text-sm text-gray-900 dark:text-white
                                                file:mr-4 file:py-2 file:px-4
                                                file:rounded-md file:border-0
                                                file:text-sm file:font-semibold
                                                file:bg-green-500 file:text-white
                                                hover:file:bg-green-700
                                                dark:file:bg-green-500 dark:hover:file:bg-green-600
                                                cursor-pointer" required />
                                        <x-input-error :messages="$errors->get('attestation')" class="mt-2" />
                                    </div>

                                    <div class="mt-6">
                                        <x-input-label for="petsitter_certificate_acaced" :value="__('Attestation de Connaissances pour les Animaux de Compagnie (ACACED)')" />
                                        <input type="file" name="petsitter_certificate_acaced"
                                            class="block mt-1 w-full text-sm text-gray-900 dark:text-white
                                                file:mr-4 file:py-2 file:px-4
                                                file:rounded-md file:border-0
                                                file:text-sm file:font-semibold
                                                file:bg-green-500 file:text-white
                                                hover:file:bg-green-700
                                                dark:file:bg-green-500 dark:hover:file:bg-green-600
                                                cursor-pointer" required />
                                        <x-input-error :messages="$errors->get('petsitter_certificate_acaced')" class="mt-2" />
                                    </div><br>

                                    <button type="submit" class="w-full bg-green-500 hover:bg-green-600 text-white font-medium py-2 rounded-md transition duration-200">
                                        Ajouter les documents
                                    </button>

                                </form>
                                <div class="mt-8">
                                    <button
                                        onclick="document.getElementById('popup-modal').classList.add('hidden')"
                                        class="w-full bg-gray-700 hover:bg-gray-600 text-white font-medium py-2 rounded-md transition duration-200">
                                        Fermer
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layout-links>