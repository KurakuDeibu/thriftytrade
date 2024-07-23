  <!-- FOOTER -->
  <footer class="bg-light mt-5 py-4">
    <div class="container text-center">
      <p>© 2024 ThriftyTrade. All rights reserved.</p>
      <p>
        {{-- <a href="/contact" class="text-decoration-none">Contact Us</a> --}}
        <div class="ms-2">
          {!! __(':terms_of_service :privacy_policy', [
                  'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Terms of Service').'</a>',
                  'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Privacy Policy').'</a>',
          ]) !!}
      </div>
      </p>
    </div>
  </footer>
  <!-- END OF FOOTER -->