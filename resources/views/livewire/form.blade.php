<div>
    <a href="/" class="underline text-blue-500">Back</a>
    <h1 class="text-2xl mb-4">Form</h1>
    <p class="mb-4">The root cause of why programmers do CRUD (Create, Read, Update, and Delete)</p>
    {!! $content !!}
    <form wire:submit="save" x-data="{ showPassword: false, showPasswordConfirmation: false }">
        <div class="mb-4">
            <label for="username" class="block">Username</label>
            <input id="username" type="text" wire:model="form.username" placeholder="Username" class="block w-full rounded">
            @error('form.username') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>
        <div class="mb-4">
            <label for="email" class="block">Email</label>
            <input id="email" type="email" wire:model="form.email" placeholder="Email" class="block w-full rounded">
            @error('form.email') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>
        <div class="mb-4">
            <label for="password" class="block">Password</label>
            <div class="relative">
                <input :type="showPassword ? 'text' : 'password'" wire:model="form.password" placeholder="Password" class="block w-full rounded">
                <button type="button" class="absolute inset-y-0 right-0 px-4 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-500 border border-transparent rounded-r-md active:bg-blue-500 hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-400" @click="showPassword = !showPassword" :class="{ 'hidden': showPassword, 'block': !showPassword }">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </button>
                <button type="button" class="absolute inset-y-0 right-0 px-4 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-500 border border-transparent rounded-r-md active:bg-blue-500 hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-400" @click="showPassword = !showPassword" :class="{ 'hidden': !showPassword, 'block': showPassword }">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                    </svg>
                </button>
            </div>
            @error('form.password') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>
        <div class="mb-4">
            <label for="password-confirmation" class="block">Password Confirmation</label>
            <div class="relative">
                <input id="password-confirmation" :type="showPasswordConfirmation ? 'text' : 'password'" wire:model="form.password_confirmation" placeholder="Password Confirmation" class="block w-full rounded">
                <button type="button" class="absolute inset-y-0 right-0 px-4 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-500 border border-transparent rounded-r-md active:bg-blue-500 hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-400" @click="showPasswordConfirmation = !showPasswordConfirmation" :class="{ 'hidden': showPasswordConfirmation, 'block': !showPasswordConfirmation }">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </button>
                <button type="button" class="absolute inset-y-0 right-0 px-4 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-500 border border-transparent rounded-r-md active:bg-blue-500 hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-400" @click="showPasswordConfirmation = !showPasswordConfirmation" :class="{ 'hidden': !showPasswordConfirmation, 'block': showPasswordConfirmation }">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                    </svg>
                </button>
            </div>
            @error('form.password_confirmation') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>
        <div class="mb-4">
            <fieldset class="block">
                <legend>Gender</legend>
                <label>
                    <input type="radio" value="male" wire:model="form.gender"> Male
                </label>
                <label>
                    <input type="radio" value="female" wire:model="form.gender"> Female
                </label>
            </fieldset>
            @error('form.gender') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>
        <div class="mb-4">
            <fieldset class="block">
                <legend>Hobbies</legend>
                <label class="block">
                    <input type="checkbox" value="walking" wire:model="form.hobbies"> Walking
                </label>
                <label class="block">
                    <input type="checkbox" value="cycling" wire:model="form.hobbies"> Cycling
                </label>
                <label class="block">
                    <input type="checkbox" value="weight training" wire:model="form.hobbies"> Weight Training
                </label>
                <label class="block">
                    <input type="checkbox" value="swimming" wire:model="form.hobbies"> Swimming
                </label>
                <label class="block">
                    <input type="checkbox" value="playing music" wire:model="form.hobbies"> Playing Music
                </label>
                <label class="block">
                    <input type="checkbox" value="sing a song" wire:model="form.hobbies"> Sing a Song
                </label>
                <label class="block">
                    <input type="checkbox" value="other" wire:model="form.hobbies"> Other
                </label>
                <div>
                    <label for="">
                        Please tell me your hobby
                        <input type="text" wire:model="form.otherHobby" placeholder="My hobby is" class="rounded">
                    </label>
                </div>
                @error('form.hobbies') <span class="text-red-500">{{ $message }}</span> @enderror
            </fieldset>
        </div>
        <div class="mb-4">
            <label for="continent" class="block">Continent</label>
            <select wire:model="form.continent" class="block w-full rounded">
                <option value="">Continent</option>
                <option value="asia">Asia</option>
                <option value="africa">Africa</option>
                <option value="north_america">North America</option>
                <option value="south_america">South America</option>
                <option value="antartic">Antartic</option>
                <option value="eropa">Eropa</option>
                <option value="australia">Australia</option>
            </select>
            @error('form.continent') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>
        <div class="mb-4">
            <label for="bio" class="block">Tell bit about your self</label>
            <textarea id="bio" wire:model="form.bio" cols="30" rows="10" class="block w-full rounded" placeholder="I am..."></textarea>
            @error('form.bio') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>
        <div class="mb-4">
            <label for="dob" class="block">Date of Birth</label>
            <input id="dob" wire:model="form.dob" type="date" class="block w-full rounded">
            @error('form.dob') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>
        <button class="bg-blue-500 p-2 rounded text-white">Submit</button>
        <button class="bg-gray-300 p-2 rounded" type="button" wire:click="clean">Reset</button>
    </form>

    @if (!empty($data))
    <pre style="overflow-x: scroll;">
        <code>
            {{ @json_encode($data) }}
        </code>
    </pre>
    @else
        <p class="my-4">No data available.</p>
    @endif
</div>
