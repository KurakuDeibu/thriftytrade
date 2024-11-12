  <style>
      .footer {
          position: absolute;
          bottom: 0;
          width: 100%;
          height: 2.5rem;

      }
  </style>
  <!-- FOOTER -->
  <footer class="py-4 mt-5 bg-light">
      <div class="container text-center">
          <p>© 2024 ThriftyTrade. All rights reserved.</p>
          <p>
              {{-- <a href="/contact" class="text-decoration-none">Contact Us</a> --}}
          <div class="ms-2">
              {!! __(':terms_of_service :privacy_policy', [
                  'terms_of_service' =>
                      '<a href="' .
                      route('terms.show') .
                      '" class="text-sm text-gray-600 underline rounded-md hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">' .
                      __('Terms of Service') .
                      '</a>',
                  'privacy_policy' =>
                      '<a href="' .
                      route('policy.show') .
                      '" class="text-sm text-gray-600 underline rounded-md hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">' .
                      __('Privacy Policy') .
                      '</a>',
              ]) !!}
          </div>
          </p>
      </div>
  </footer>
  <!-- END OF FOOTER -->
