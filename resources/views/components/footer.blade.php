<footer class="bg-dark text-white pt-5 pb-4 mt-5 border-top border-secondary" id="application-wide-footer">
    <div class="container text-md-start text-center">
        <div class="row">
            <!-- Company Brief -->
            <div class="col-md-4 col-lg-4 col-xl-3 mx-auto mt-3">
                <h5 class="text-uppercase mb-4 font-weight-bold text-warning d-flex align-items-center justify-content-md-start justify-content-center">
                    <i class="bi bi-building-fill me-2 fs-5"></i> Prestige Residences
                </h5>
                <p class="text-white-50 small">
                    A comprehensive property portal offering curated luxury apartments, spacious modern family homes,
                    commercial listings, and land properties under complete transparency and robust client representation.
                </p>
            </div>

            <!-- Quick Links -->
            <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mt-3">
                <h6 class="text-uppercase mb-4 font-weight-bold text-warning">Categories</h6>
                <p class="mb-2"><a href="#" class="text-white-50 text-decoration-none small">Luxury Villas</a></p>
                <p class="mb-2"><a href="#" class="text-white-50 text-decoration-none small">Sky Penthouses</a></p>
                <p class="mb-2"><a href="#" class="text-white-50 text-decoration-none small">Modern Lofts</a></p>
                <p class="mb-2"><a href="#" class="text-white-50 text-decoration-none small">Suburban Homes</a></p>
            </div>

            <!-- Contact Details -->
            <div class="col-md-3 col-lg-2 col-xl-3 mx-auto mt-3">
                <h6 class="text-uppercase mb-4 font-weight-bold text-warning">Contact Support</h6>
                <div class="text-white-50 small">
                    <p class="mb-2"><i class="bi bi-geo-alt-fill me-2 text-warning"></i> 100 Sunset Blvd, Beverly Hills</p>
                    <p class="mb-2"><i class="bi bi-envelope-fill me-2 text-warning"></i> care@prestige.com</p>
                    <p class="mb-2"><i class="bi bi-telephone-fill me-2 text-warning"></i> +1 (555) 102-3928</p>
                    <p class="mb-2"><i class="bi bi-clock-fill me-2 text-warning"></i> Mon - Sat: 9:00 AM - 6:00 PM</p>
                </div>
            </div>

            <!-- Academic Disclaimer -->
            <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mt-3">
                <h6 class="text-uppercase mb-4 font-weight-bold text-warning">Academic Project</h6>
                <p class="text-white-50 small">
                    This system is fully operational. It demonstrates professional MVC architecture, database state tracking, 
                    session management, and image handling built directly with Bootstrap 5 templates.
                </p>
                <form onsubmit="event.preventDefault(); alert('Newsletter subscription is registered! Thank you.');" class="d-flex mt-3">
                    <input type="email" required placeholder="Enter email..." class="form-control form-control-sm bg-dark border-secondary text-white me-1" />
                    <button type="submit" class="btn btn-warning btn-sm">Subscribe</button>
                </form>
            </div>
        </div>

        <hr class="mb-4 mt-4 border-secondary" />

        <div class="row align-items-center">
            <div class="col-md-7 col-lg-8">
                <p class="small text-white-50 mb-0">
                    © {{ date('Y') }} Prestige Residences. All rights reserved. Powered by <strong>Laravel & Bootstrap 5</strong> inspired designs.
                </p>
            </div>
            <div class="col-md-5 col-lg-4 text-md-end mt-2 mt-md-0">
                <div class="d-inline-flex gap-3">
                    <a href="#" class="text-white-50 fs-5"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="text-white-50 fs-5"><i class="bi bi-twitter-x"></i></a>
                    <a href="#" class="text-white-50 fs-5"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="text-white-50 fs-5"><i class="bi bi-linkedin"></i></a>
                </div>
            </div>
        </div>
    </div>
</footer>