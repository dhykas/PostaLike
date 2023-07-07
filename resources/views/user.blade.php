@extends('partials/html')
@section('body')
<link rel="stylesheet" href="https://demos.creative-tim.com/notus-js/assets/styles/tailwind.css">
<link rel="stylesheet" href="https://demos.creative-tim.com/notus-js/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css">

<main class="profile-page">
  <section class="relative block h-500-px">
    <div class="absolute top-0 w-full h-full bg-center bg-cover bg-[url('/profilePic/{{ $user->cover }}')]">
      <span id="blackOverlay" class="w-full h-full absolute opacity-50 bg-black"></span>
    </div>
    <div class="top-auto bottom-0 left-0 right-0 w-full absolute pointer-events-none overflow-hidden h-70-px" style="transform: translateZ(0px)">
      <svg class="absolute bottom-0 overflow-hidden" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" version="1.1" viewBox="0 0 2560 100" x="0" y="0">
        <polygon class="text-blueGray-200 fill-current" points="2560 0 2560 100 0 100"></polygon>
      </svg>
    </div>
  </section>
  <section class="relative py-16 bg-blueGray-200">
    <div class="container mx-auto px-4">
      <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 shadow-xl rounded-lg -mt-64">
        <div class="px-6">
          <div class="flex flex-wrap justify-center">
            <div class="w-full lg:w-3/12 px-4 lg:order-2 flex justify-center">
              <div class="relative">
                <img alt="{{ $user->picture }}" src="{{ asset('profilePic/' . $user->picture ) }}" class="shadow-xl rounded-full h-auto align-middle border-none absolute -m-16 -ml-20 lg:-ml-16 max-w-150-px">
              </div>
            </div>
            <div class="w-full lg:w-4/12 px-4 lg:order-3 lg:text-right lg:self-center">
              <div class="py-6 px-3 mt-32 sm:mt-0">

                @auth
                    @if (Auth::user()->name === $user->name)
                    <a href="/acc/edit" class="bg-pink-500 active:bg-pink-600 uppercase text-white font-bold hover:shadow-md shadow text-xs px-4 py-2 rounded outline-none focus:outline-none sm:mr-2 mb-1 ease-linear transition-all duration-150" type="button">
                        Edit Profile
                    </a>
                    @endif
                @endauth

              </div>
            </div>
            <div class="w-full lg:w-4/12 px-4 lg:order-1">
              <div class="flex justify-center py-4 lg:pt-4 pt-8">
                <div class="mr-4 p-3 text-center">
                  <span class="text-xl font-bold block uppercase tracking-wide text-blueGray-600">100</span><span class="text-sm text-blueGray-400">Friends</span>
                </div>
                <div class="mr-4 p-3 text-center">
                  <span class="text-xl font-bold block uppercase tracking-wide text-blueGray-600">220</span><span class="text-sm text-blueGray-400">Likes</span>
                </div>
                <div class="lg:mr-4 p-3 text-center">
                  <span class="text-xl font-bold block uppercase tracking-wide text-blueGray-600">11</span><span class="text-sm text-blueGray-400">Post</span>
                </div>
              </div>
            </div>
          </div>
          <div class="text-center mt-12">
            <h3 class="text-4xl font-semibold leading-normal mb-2 text-blueGray-700 mb-2">
              {{ $user->name }}
            </h3>
            <div class="text-sm leading-normal mt-0 mb-2 text-blueGray-400 font-bold uppercase">
              <i class="fas fa-map-marker-alt mr-2 text-lg text-blueGray-400"></i>
              Depok, Indonesia
            </div>
            <div class="mb-2 text-blueGray-600 mt-10">
              <i class="fas fa-briefcase mr-2 text-lg text-blueGray-400"></i>{{ $user->email }}
            </div>
            <div class="mb-2 text-blueGray-600">
              <i class="fas fa-university mr-2 text-lg text-blueGray-400"></i>University of Computer Science
            </div>
            <div class="mt-3 flex flex-wrap justify-center">
              <div class="w-full lg:w-9/12 px-4">
                <p class="mb-4 text-md leading-relaxed text-blueGray-700">
                  An artist of considerable range, Jenna the name taken by
                  Melbourne-raised, Brooklyn-based Nick Murphy writes,
                  performs and records all of his own music, giving it a
                  warm, intimate feel with a solid groove structure. An
                  artist of considerable range.
                </p>

              </div>
            </div>
          </div>
          <div class="flex mt-10 py-10 border-t border-blueGray-200">
            <div class="flex flex-wrap justify-center">

              @foreach ($post as $item)
              <div class="max-w-sm rounded overflow-hidden shadow-lg m-2">
                <img src="{{ asset('profilePic/' . $item->image ) }}" alt="Card 1" class="w-full">
                <div class="px-6 py-4">
                  <div class="font-bold text-xl mb-2">
                    {{-- like --}}
                    <form action="/like/{{ $item->id }}" method="POST">
                      @csrf
                      <button type="submit">
                        @if ($item->like_count)
                        <i class="fas fa-heart text-red-500 text-3xl"></i>
                        @else
                        <i class="far fa-heart text-red-500 text-3xl p-2"></i>
                        @endif
                      </button>
                    {{ $item->like_count }}

                    </form>
                  </div>
                  <p class="text-gray-700 text-base">
                    <span class="font-bold text-md">{{ $item->user->name }}</span> {{ $item->caption }}
                  </p>
                </div>
              </div>
              @endforeach
{{-- 
              <div class="max-w-sm rounded overflow-hidden shadow-lg m-2">
                <img src="https://theperfectroundgolf.com/wp-content/uploads/2022/04/placeholder.png" alt="Card 2" class="w-full h-auto" style="max-width: 500px; max-height: 350px; object-fit: cover;">
                <div class="px-6 py-4">
                  <div class="font-bold text-xl mb-2">
                    <i class="far fa-heart text-red-500 text-3xl p-2"></i> //heart
                  </div>
                  <p class="text-gray-700 text-base">
                    <span class="font-bold text-md">{{ $user->name }}</span> Ini Caption!
                  </p>
                </div>
              </div> --}}





            </div>
            
          </div>
          
          
        </div>
      </div>
    </div>
    <footer class="relative bg-blueGray-200 pt-8 pb-6 mt-8">
  <div class="container mx-auto px-4">
    <div class="flex flex-wrap items-center md:justify-between justify-center">
      <div class="w-full md:w-6/12 px-4 mx-auto text-center">
        <div class="text-sm text-blueGray-500 font-semibold py-1">
          Made with <a href="https://www.creative-tim.com/product/notus-js" class="text-blueGray-500 hover:text-gray-800" target="_blank">Notus JS</a> by <a href="https://www.github.com/dhykas" class="text-blueGray-500 hover:text-blueGray-800" target="_blank"> Creative Team</a>.
        </div>
      </div>
    </div>
  </div>
</footer>
  </section>
</main>

<div class="fixed bottom-4 right-4">
  <a href="/create" class="gradient hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-full shadow-lg">
    <i class="fas fa-plus"></i> Create
  </a>
</div>


@endsection