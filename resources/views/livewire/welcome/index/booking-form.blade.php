  <div class="max-w-5xl mx-auto">
      <div class="glass rounded-3xl p-6 md:p-8 shadow-soft-xl border border-white/30">
          <h2 class="text-lg font-poppins font-semibold text-foreground mb-6 flex items-center gap-2">
              <svg class="w-5 h-5 text-primary" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round"
                      d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
              </svg>
              Find Your Perfect Stay
          </h2>
          <form wire:submit="save" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 items-end"
              aria-label="Booking search form">
              @csrf
              <div>
                  <label for="checkin" class="input-label">Check In</label>
                  <input type="date" wire:model="check_in" id="checkin" class="input" />
                  @error('check_in')
                      <span class="text-red-500 text-xs">{{ $message }}</span>
                  @enderror
              </div>
              <div>
                  <label for="checkout" class="input-label">Check Out</label>
                  <input type="date" wire:model="check_out" id="checkout" class="input" />
                  @error('check_out')
                      <span class="text-red-500 text-xs">{{ $message }}</span>
                  @enderror
              </div>
              <div>
                  <label for="guests" class="input-label">Guests</label>
                  <select wire:model="total_guest" id="guests" class="input">
                      <option>1 Guest</option>
                      <option>2 Guests</option>
                      <option>3 Guests</option>
                      <option>4+ Guests</option>
                  </select>
              </div>
              <div>
                  <label for="room-type" class="input-label">Room Type</label>
                  <select wire:model="roomType" id="room-type" class="input">
                      <option>All Types</option>
                      <option>Deluxe Room</option>
                      <option>Superior Room</option>
                      <option>Lake Villa</option>
                      <option>Presidential Suite</option>
                  </select>
              </div>
              <button type="submit" class="btn-primary !py-3 w-full">
                  <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round"
                          d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                  </svg>
                  Search
              </button>
          </form>
      </div>
  </div>
