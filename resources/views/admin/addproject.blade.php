<x-layouts.app>
    <x-slot name="header">
        <!--written on 26.04.2025-->
        @include('admin.layouts.header')
    </x-slot>
    <main class="ml-64 mt-[100px] flex-1 bg-[#F9F7F7] min-h-screen  items-center">
        <!--head begins-->

        <div class="p-6 bg-[#F9F7F7]">
            <div class="mb-[20px]">

                {{-- navigation bar --}}
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center justify-between mb-6">
                        <span>
                            <iconify-icon icon="akar-icons:home"
                                class="w-[5] h-[5] text-fuchsia-900 ml-[3px]"></iconify-icon>
                        </span>
                        <span>
                            <iconify-icon icon="mingcute:right-line" width="23px"
                                class=" text-gray-300 mr-[8px] ml-[8px] mt-[4px] "></iconify-icon>
                        </span>
                        <a href="{{ route('admin.ProjectManagement') }}">
                            <h3 class="font-sans font-normal text-black cursor-pointer text-[15px] hover:underline">
                                Project Management</h3>
                        </a>
                        <span>
                            <iconify-icon icon="mingcute:right-line" width="23px"
                                class=" text-gray-300 mr-[8px] ml-[8px] mt-[4px] "></iconify-icon>
                        </span>
                        <!-- ADD CLIENT BUTTON -->
                        <h3 class="font-sans font-semibold cursor-pointer text-[15px] text-fuchsia-900">
                            Add New Project</h3>


                    </div>

                </div>


                <form method="POST" action="{{ route('projects.store') }}" x-data="projectWizard()"
                    @submit.prevent="submit">
                    @csrf
                    <!-- STEP 0: Basic -->
                    <!-- Wrapper -->
                    <div x-show="step === 0" x-transition>

                        <div class="p-4 mx-auto w-[450px]">


                            <div class="mt-4">
                                <!-- Label -->
                                <label for="glass_type" class="block text-[15px] mb-2 font-semibold text-gray-900">
                                    Project Name
                                    {{-- <span class="font-normal text-gray-500">(Select mirror for wardrobes with mirrors)</span> --}}
                                </label> <input type="text" x-model.trim="form.name" name="name"
                                    class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-[#5A0562]">
                                <p class="mt-1 text-sm text-red-600" x-text="errors.name"></p>
                            </div>


                        </div>



                        <!-- STEP 1: Finish -->
                        <div x-show="step === 1" x-transition>

                            <div class="p-4 mx-auto w-[450px]">
                                <div class="mt-4">
                                    <!-- Label -->
                                    <label for="glass_type" class="block text-[15px] mb-2 font-semibold text-gray-900">
                                        Project Name
                                        {{-- <span class="font-normal text-gray-500">(Select mirror for wardrobes with mirrors)</span> --}}
                                    </label> <input type="text" x-model.trim="form.name" name="name"
                                        class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-[#5A0562]">
                                    <p class="mt-1 text-sm text-red-600" x-text="errors.name"></p>
                                </div>

                            </div>
                        </div>

                        <!-- STEP 2: Glassdoor -->
                        <div x-show="step === 2" x-transition>
                            <div class="p-4 mx-auto w-[450px]">
                                <!-- Label -->
                                <label for="glass_type" class="block text-[15px] mb-2 font-semibold text-gray-900">
                                    Select Client
                                    {{-- <span class="font-normal text-gray-500">(Select mirror for wardrobes with mirrors)</span> --}}
                                </label>
                            </div>
                        </div>

                        <!-- STEP 3: Worktop -->
                        <div x-show="step === 3" x-transition>
                            <div class="p-4 mx-auto w-[450px]">
                                <!-- Label -->
                                <label for="glass_type" class="block text-[15px] mb-2 font-semibold text-gray-900">
                                    Select Client
                                    {{-- <span class="font-normal text-gray-500">(Select mirror for wardrobes with mirrors)</span> --}}
                                </label>
                            </div>
                        </div>

                        <!-- STEP 4: Sink & Top -->

                        <div x-show="step === 4" x-transition>

                            <div class="p-4 mx-auto w-[450px]">
                                <!-- Label -->
                                <label for="glass_type" class="block text-[15px] mb-2 font-semibold text-gray-900">
                                    Select Client
                                    {{-- <span class="font-normal text-gray-500">(Select mirror for wardrobes with mirrors)</span> --}}
                                </label>
                            </div>
                        </div>

                        <!-- STEP 5: Appliances -->
                        <div x-show="step === 5" x-transition>
                            <div class="p-4 mx-auto w-[450px]">
                                <!-- Label -->
                                <div class="mt-4">
                                    <!-- Label -->
                                    <label for="glass_type" class="block text-[15px] mb-2 font-semibold text-gray-900">
                                        Project Name
                                        {{-- <span class="font-normal text-gray-500">(Select mirror for wardrobes with mirrors)</span> --}}
                                    </label> <input type="text" x-model.trim="form.name" name="name"
                                        class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-[#5A0562]">
                                    <p class="mt-1 text-sm text-red-600" x-text="errors.name"></p>
                                </div>
                            </div>
                        </div>

                        <!-- STEP 6: Information -->
                        <div x-show="step === 6" x-transition>
                            <div class="p-4 mx-auto w-[450px]">
                                <!-- Label -->
                                <div class="mt-4">
                                    <!-- Label -->
                                    <label for="glass_type" class="block text-[15px] mb-2 font-semibold text-gray-900">
                                        Project Name
                                        {{-- <span class="font-normal text-gray-500">(Select mirror for wardrobes with mirrors)</span> --}}
                                    </label> <input type="text" x-model.trim="form.name" name="name"
                                        class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-[#5A0562]">
                                    <p class="mt-1 text-sm text-red-600" x-text="errors.name"></p>
                                </div>
                            </div>
                        </div>

                        <!-- STEP 7: Summary / Preview -->
                        <div x-show="step === 7" x-transition>

                            <div class="p-4 mx-auto w-[450px]">
                                <!-- Label -->

                            </div>
                        </div>



                        {{-- <div class="flex items-center justify-between pt-2"> --}}
                        <div class="grid w-[450px] grid-cols-1 gap-5 p-4 mx-auto mt-8 md:grid-cols-2">

                            <button type="button"
                                class="w-full rounded-[15px] px-[28px] py-[10px] text-fuchsia-900 bg-transparent
                   border-2 border-[#5A0562] text-[17px] font-semibold
                   hover:bg-[#5A0562]/10 focus:outline-none focus:ring-2 focus:ring-[#5A0562]/50"
                                :disabled="step === 0" @click="prev">
                                PREVIOUS
                            </button>

                            <template x-if="step < steps.length - 1">
                                <button type="button"
                                    class="w-full rounded-[15px] px-[28px] py-[10px] text-white bg-[#5A0562]
                   text-[17px] font-semibold
                   hover:opacity-95 focus:outline-none focus:ring-2 focus:ring-[#5A0562]/50"
                                    @click="next">
                                    NEXT
                                </button>
                            </template>

                            <template x-if="step === steps.length - 1">
                                <button type="submit"
                                    class="w-full rounded-[18px] px-8 py-4 text-white bg-[#5A0562]
                   text-[20px] font-semibold
                   hover:opacity-95 focus:outline-none focus:ring-2 focus:ring-[#5A0562]/50"
                                    :disabled="submitting">
                                    <span x-show="!submitting">Submit</span>
                                    <span x-show="submitting">Submitting…</span>
                                </button>
                            </template>
                        </div>
                </form>



                <script>
                    function projectWizard() {
                        return {
                            steps: ['Basic', 'Finish', 'Glassdoor', 'Worktop', 'Sink & Top', 'Appliances', 'Information', 'Summary'],
                            step: 0,
                            submitting: false,
                            errors: {},

                            // Map user IDs to display names in Summary (optional enhancement)
                            userMap: {
                                @foreach ($users ?? [] as $u)
                                    {{ $u->id }}: @json($u->name),
                                @endforeach
                            },

                            form: {
                                name: '',
                                client_id: '',
                                status: 'ON_GOING',
                                current_stage: '',
                                booked_status: 'UNBOOKED',
                                estimated_budget: '',
                                admin_id: '',
                                tech_supervisor_id: '',
                                designer_id: '',
                                production_officer_id: '',
                                installation_officer_id: '',
                                notes: '',
                            },

                            labelFor(id) {
                                return this.userMap[id] ?? '—';
                            },
                            formatMoney(v) {
                                if (!v) return '—';
                                const n = Number(v);
                                return isNaN(n) ? v : new Intl.NumberFormat().format(n);
                            },

                            go(i) {
                                this.step = i;
                            },

                            // Step-wise validation
                            validate() {
                                this.errors = {};
                                if (this.step === 0) {
                                    if (!this.form.name) this.errors.name = 'Project name is required.';
                                    if (!this.form.client_id) this.errors.client_id = 'Client is required.';
                                }
                                return Object.keys(this.errors).length === 0;
                            },

                            next() {
                                if (!this.validate()) return;
                                this.step = Math.min(this.step + 1, this.steps.length - 1);
                            },
                            prev() {
                                this.step = Math.max(this.step - 1, 0);
                            },

                            async submit(e) {
                                // Optional final validation before submit
                                this.step = this.steps.length - 1;
                                if (!this.validate()) {
                                    this.step = 0;
                                    return;
                                }

                                this.submitting = true;
                                // Let the browser submit the form normally after preventing default
                                e.target.submit();
                            }
                        }
                    }
                </script>

            </div>
        </div>
    </main>
</x-layouts.app>
