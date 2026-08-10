 <div class="max-w-7xl mx-auto">
     <!-- Header -->
     <div class="text-center mb-14 animate-on-scroll">
         <div class="gold-line-center mb-4"></div>
         <h2 class="section-title">Resort <span class="text-gradient-accent">Facilities</span></h2>
     </div>

     <!-- Facilities Grid -->
     <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 md:gap-6">

         @foreach ($rooms->flatMap(fn($room) => $room->facilities)->unique()->take(6) as $facility)
             <div
                 class="card text-center p-6 group hover:border-primary/20 border border-transparent animate-on-scroll stagger-1">
                 <div
                     class="w-14 h-14 bg-primary/10 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:bg-primary group-hover:text-white transition-all duration-300">
                     <div
                         class="text-2xl text-primary group-hover:text-white transition-colors [&svg]:text-primary [&svg]:group-hover:text-white">
                         {!! $facility->icon !!}
                     </div>
                 </div>
                 <h3 class="font-poppins font-semibold text-sm text-foreground">{{ $facility->name }}</h3>
                 <p class="text-xs text-gray-500 mt-1">{{ $facility->description }}</p>
             </div>
         @endforeach
     </div>
 </div>
