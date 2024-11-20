        <!-- FOOTER TOP -->
        <footer class="mt-5">
            <div class="container">
                <div class="row">
                    <!-- About Section -->
                    <div class="footer-section col-md-6">
                        <div class="footer-logo mb-2">
                            <a href="{{ route('home') }}">
                                <img src="{{ asset('img/thriftytrade-logo.png') }}" alt="ThriftyTrade Logo"
                                    style="height: 4rem;">
                            </a>
                        </div>
                        <p>Your gateway to easier thrifting, buying, and selling locally. Connect, trade, and discover
                            amazing deals!</p>

                        <!-- Social Icons moved here -->
                        <div class="social-icons mt-3">
                            <a href="https://facebook.com" target="_blank"><i class="fab fa-facebook-f"></i></a>
                            <a href="https://twitter.com" target="_blank"><i class="fab fa-twitter"></i></a>
                            <a href="https://instagram.com" target="_blank"><i class="fab fa-instagram"></i></a>
                            <a href="https://linkedin.com" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                        </div>

                    </div>

                    {{-- Category Section --}}
                    <div class="footer-section col-md-2">
                        <h5>Categories</h5>
                        <ul>
                            @foreach (\App\Models\Category::all() as $category)
                                <li>
                                    <a href="{{ route('marketplace', ['category' => $category->id]) }}"
                                        class="text-decoration-none">
                                        {{ $category->categName }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Quick Links -->
                    <div class="footer-section col-md-2">
                        <h5>Quick Links</h5>
                        <ul>
                            <li><a href="{{ route('home') }}">Home</a></li>
                            <li><a href="{{ route('marketplace') }}">Marketplace</a></li>
                            <li><a href="{{ route('listing.create') }}">Sell</a></li>
                            <li><a href="{{ route('manage-listing') }}">Listings</a></li>
                            <li><a href="{{ route('seller-offers') }}">Offers</a></li>
                        </ul>
                    </div>


                    <!-- Support Links -->
                    <div class="footer-section col-md-2">
                        <h5>Support</h5>
                        <ul>
                            <li><a href="{{ route('terms.show') }}">Terms of Service</a></li>
                            <li><a href="{{ route('policy.show') }}">Privacy Policy</a></li>
                            <li><a href="#">Contact Us</a></li>
                        </ul>
                    </div>




                </div>
            </div>
            </div>
        </footer>

        <!-- Scroll to Top Button -->
        <button id="scrollToTop" title="Scroll to Top">
            <i class="fas fa-arrow-up"></i>
        </button>

        <!-- JavaScript for Scroll to Top -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const scrollToTopBtn = document.getElementById('scrollToTop');

                // Show/hide scroll to top button
                window.addEventListener('scroll', function() {
                    if (window.pageYOffset > 300) {
                        scrollToTopBtn.classList.add('show');
                    } else {
                        scrollToTopBtn.classList.remove('show');
                    }
                });

                // Scroll to top when button is clicked
                scrollToTopBtn.addEventListener('click', function() {
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                });
            });
        </script>

        <style>
            /* Footer Styles */
            footer {
                background-color: #dfe1e24a;
                padding: 4rem 0;
                color: #333;
            }

            .footer-section {
                margin-bottom: 1.5rem;
            }

            .footer-section h5 {
                font-weight: 600;
                margin-bottom: 1rem;
                color: #2c3e50;
            }

            .footer-section ul {
                list-style: none;
                padding: 0;
            }

            .footer-section ul li {
                margin-bottom: 0.5rem;
            }

            .footer-section ul li a {
                text-decoration: none;
                transition: color 0.3s ease;
            }

            .footer-section ul li a:hover {
                color: #007bff;
            }

            .social-icons a {
                color: #6c757d;
                margin-right: 1rem;
                font-size: 1.5rem;
                transition: color 0.3s ease;
            }

            .social-icons a:hover {
                color: #007bff;
            }

            .footer-bottom {
                border-top: 1px solid #e9ecef;
                padding-top: 1.5rem;
                margin-top: 2rem;
                text-align: center;
            }

            /* Scroll to Top Button */
            #scrollToTop {
                position: fixed;
                bottom: 20px;
                right: 20px;
                background-color: #007bff;
                color: white;
                border: none;
                border-radius: 50%;
                width: 50px;
                height: 50px;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                z-index: 1000;
                opacity: 0;
                transition: opacity 0.3s ease;
            }

            #scrollToTop:hover {
                background-color: #0056b3;
            }

            #scrollToTop.show {
                opacity: 1;
            }

            /* Responsive Adjustments */
            @media (max-width: 768px) {
                footer {
                    padding: 2rem 0;
                }

                .footer-section {
                    text-align: center;
                    margin-bottom: 1.5rem;
                }

                .footer-section ul {
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                }

                .social-icons {
                    display: flex;
                    justify-content: center;
                    gap: 1rem;
                }

                #scrollToTop {
                    width: 40px;
                    height: 40px;
                    right: 15px;
                    bottom: 15px;
                }
            }
        </style>
