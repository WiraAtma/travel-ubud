<x-app-layout>
<section class="wrapper">
  restoran - coding disini 

  @auth
      @if(auth()->user()->role  == 'company' && auth()->user()->company_role == 'restaurant')
      <a href="{{ url('/admin/destination/create') }}" 
         class="fixed bottom-6 right-6 z-50 flex items-center gap-2 px-6 py-3 bg-blue-600 text-white rounded-full shadow-lg hover:bg-blue-700 transition-all duration-300 hover:scale-105 focus:outline-none focus:ring-4 focus:ring-blue-300 no-underline hover:text-white">               
          <i class="bi bi-plus-lg text-xl"></i>
          <span class="font-semibold">Buat Restoran</span>
      </a>
  @endauth
</section>
</x-app-layout>
