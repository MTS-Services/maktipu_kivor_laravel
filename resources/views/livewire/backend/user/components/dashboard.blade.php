<div class="space-y-6">
    <!-- Filters -->
    <div class="flex flex-col sm:flex-row gap-4">
        <div class="relative" id="dropdown-wrapper">
            <select id="status-select"
                class="bg-gray-900 border text-base border-purple-700 w-full sm:w-70 text-gray-300 rounded-lg pl-4 pr-10 py-1 focus:outline-none focus:border-purple-500 transition-all appearance-none cursor-pointer">
                <option value="">All statuses</option>
                <option value="completed">Completed</option>
                <option value="pending">Pending</option>
                <option value="processing">Processing</option>
            </select>
            <div id="icon-container" class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none">
                <flux:icon name="chevron-down" class="w-4 h-4 text-gray-300" stroke="white" />
            </div>
        </div>

        <div class="relative">
            <select
                class="bg-gray-900 border border-purple-700 w-full sm:w-70 text-gray-300 rounded-lg pl-4 pr-10 py-1 text-base focus:outline-none focus:border-purple-500 transition-all appearance-none cursor-pointer">
                <option value="">Recent</option>
                <option value="today">Today</option>
                <option value="week">This Week</option>
                <option value="month">This Month</option>
            </select>
            <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none">
                <flux:icon name="chevron-down" class="w-4 h-4 text-gray-300" stroke="white" />
            </div>
        </div>
    </div>

    <div class="bg-zinc-950 min-h-[90vh] font-sans">

        <div class="overflow-x-auto shadow-2xl">
            <table class="w-full text-left table-auto border-separate border-spacing-0">
                <thead>
                    <tr class=" text-sm text-zinc-100 uppercase tracking-wider">
                        <th
                            class="px-4 md:px-6 py-5 text-sm md:text-base text-zinc-50 capitalize font-normal flex items-center gap-1">
                            Order Name
                            <span>
                                <img src="{{ asset('assets/icons/ic_round-arrow-left.png') }}" class="w-full h-full"
                                    alt="">
                            </span>
                        </th>
                        <th class="px-4 md:px-6 py-5 text-sm md:text-base text-zinc-50 capitalize font-normal">Type</th>
                        <th class="px-4 md:px-6 py-5 text-sm md:text-base text-zinc-50 capitalize font-normal">Seller
                        </th>
                        <th
                            class="px-4 md:px-6 py-5 text-sm md:text-base text-zinc-50 capitalize font-normal whitespace-nowrap">
                            Ordered date</th>
                        <th
                            class="px-4 md:px-6 py-5 text-sm md:text-base text-zinc-50 capitalize font-normal whitespace-nowrap">
                            Order status</th>
                        <th class="px-4 md:px-6 py-5 text-sm md:text-base text-zinc-50 capitalize font-normal">Quantity
                        </th>
                        <th class="px-4 md:px-6 py-5 text-sm md:text-base text-zinc-50 capitalize font-normal">Price ($)
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-800">
                    <tr class="bg-bg-primary hover:bg-zinc-950 transition-colors">
                        <td class="px-4 md:px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-orange-600 flex-shrink-0">
                                    <img src="{{ asset('assets/images/order.png') }}" alt="Fortnite Logo" class="w-full h-full rounded-lg" />
                                </div>
                                <div class="min-w-0">
                                    <h3 class="font-semibold text-zinc-50 text-sm md:text-base">Fortnite VB Skin Gift
                                    </h3>
                                    <p class="text-xs text-green-400 truncate">Cheapest +75% Discount</p>
                                    <a href="#"
                                        class="text-pink-400 text-xs hover:underline flex items-center gap-1">Learn
                                        more →</a>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 md:px-6 py-4 text-zinc-100 text-sm">Items</td>
                        <td class="px-4 md:px-6 py-4 text-zinc-100 text-sm">Albert Flores</td>
                        <td class="px-4 md:px-6 py-4 text-zinc-100 text-sm whitespace-nowrap">February 11, 2014</td>
                        <td class="px-4 md:px-6 py-4">
                            <span
                                class="px-3 py-1 text-xs font-semibold rounded-full bg-pink-500 text-white whitespace-nowrap inline-block">Completed</span>
                        </td>
                        <td class="px-4 md:px-6 py-4 text-zinc-100 text-sm">7421</td>
                        <td class="px-4 md:px-6 py-4 text-zinc-50 font-semibold text-sm">$4.75</td>
                    </tr>

                    <tr class=" hover:bg-bg-primary/60 transition-colors">
                        <td class="px-4 md:px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-orange-600 flex-shrink-0">
                                    <img src="{{ asset('assets/images/order.png') }}" alt="Fortnite Logo" class="w-full h-full rounded-lg" />
                                </div>
                                <div class="min-w-0">
                                    <h3 class="font-semibold text-zinc-50 text-sm md:text-base">Fortnite VB Skin Gift
                                    </h3>
                                    <p class="text-xs text-green-400 truncate">Cheapest +75% Discount</p>
                                    <a href="#"
                                        class="text-pink-400 text-xs hover:underline flex items-center gap-1">Learn
                                        more →</a>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 md:px-6 py-4 text-zinc-100 text-sm">Items</td>
                        <td class="px-4 md:px-6 py-4 text-zinc-100 text-sm">Jenny Wilson</td>
                        <td class="px-4 md:px-6 py-4 text-zinc-100 text-sm whitespace-nowrap">February 28, 2018</td>
                        <td class="px-4 md:px-6 py-4">
                            <span
                                class="px-3 py-1 text-xs font-semibold rounded-full bg-pink-500 text-white whitespace-nowrap inline-block">Completed</span>
                        </td>
                        <td class="px-4 md:px-6 py-4 text-zinc-100 text-sm">5832</td>
                        <td class="px-4 md:px-6 py-4 text-zinc-50 font-semibold text-sm">$15.30</td>
                    </tr>

                    <tr class="bg-bg-primary hover:bg-bg-primary/60 transition-colors">
                        <td class="px-4 md:px-6 py-4">
                            <div class="flex items-center gap-3">
                                 <div class="w-10 h-10 rounded-lg bg-orange-600 flex-shrink-0">
                                    <img src="{{ asset('assets/images/order.png') }}" alt="Fortnite Logo" class="w-full h-full rounded-lg" />
                                </div>
                                <div class="min-w-0">
                                    <h3 class="font-semibold text-zinc-50 text-sm md:text-base">Fortnite VB Skin Gift
                                    </h3>
                                    <p class="text-xs text-green-400 truncate">Cheapest +75% Discount</p>
                                    <a href="#"
                                        class="text-pink-400 text-xs hover:underline flex items-center gap-1">Learn
                                        more →</a>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 md:px-6 py-4 text-zinc-100 text-sm">Items</td>
                        <td class="px-4 md:px-6 py-4 text-zinc-100 text-sm">Ralph Edwards</td>
                        <td class="px-4 md:px-6 py-4 text-zinc-100 text-sm whitespace-nowrap">May 20, 2015</td>
                        <td class="px-4 md:px-6 py-4">
                            <span
                                class="px-3 py-1 text-xs font-semibold rounded-full bg-pink-500 text-white whitespace-nowrap inline-block">Completed</span>
                        </td>
                        <td class="px-4 md:px-6 py-4 text-zinc-100 text-sm">6190</td>
                        <td class="px-4 md:px-6 py-4 text-zinc-50 font-semibold text-sm">$10.25</td>
                    </tr>

                    <tr class=" hover:bg-bg-primary/60 transition-colors">
                        <td class="px-4 md:px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-orange-600 flex-shrink-0">
                                    <img src="{{ asset('assets/images/order.png') }}" alt="Fortnite Logo" class="w-full h-full rounded-lg" />
                                </div>
                                <div class="min-w-0">
                                    <h3 class="font-semibold text-zinc-50 text-sm md:text-base">Fortnite VB Skin Gift
                                    </h3>
                                    <p class="text-xs text-green-400 truncate">Cheapest +75% Discount</p>
                                    <a href="#"
                                        class="text-pink-400 text-xs hover:underline flex items-center gap-1">Learn
                                        more →</a>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 md:px-6 py-4 text-zinc-100 text-sm">Items</td>
                        <td class="px-4 md:px-6 py-4 text-zinc-100 text-sm">Theresa Webb</td>
                        <td class="px-4 md:px-6 py-4 text-zinc-100 text-sm whitespace-nowrap">May 29, 2017</td>
                        <td class="px-4 md:px-6 py-4">
                            <span
                                class="px-3 py-1 text-xs font-semibold rounded-full bg-pink-500 text-white whitespace-nowrap inline-block">Completed</span>
                        </td>
                        <td class="px-4 md:px-6 py-4 text-zinc-100 text-sm">8347</td>
                        <td class="px-4 md:px-6 py-4 text-zinc-50 font-semibold text-sm">$13.60</td>
                    </tr>

                    <tr class="bg-bg-primary hover:bg-bg-primary/60 transition-colors">
                        <td class="px-4 md:px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-orange-600 flex-shrink-0">
                                    <img src="{{ asset('assets/images/order.png') }}" alt="Fortnite Logo" class="w-full h-full rounded-lg" />
                                </div>
                                <div class="min-w-0">
                                    <h3 class="font-semibold text-zinc-50 text-sm md:text-base">Fortnite VB Skin Gift
                                    </h3>
                                    <p class="text-xs text-green-400 truncate">Cheapest +75% Discount</p>
                                    <a href="#"
                                        class="text-pink-400 text-xs hover:underline flex items-center gap-1">Learn
                                        more →</a>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 md:px-6 py-4 text-zinc-100 text-sm">Items</td>
                        <td class="px-4 md:px-6 py-4 text-zinc-100 text-sm">Marvin McKinney</td>
                        <td class="px-4 md:px-6 py-4 text-zinc-100 text-sm whitespace-nowrap">December 29, 2012</td>
                        <td class="px-4 md:px-6 py-4">
                            <span
                                class="px-3 py-1 text-xs font-semibold rounded-full bg-pink-500 text-white whitespace-nowrap inline-block">Completed</span>
                        </td>
                        <td class="px-4 md:px-6 py-4 text-zinc-100 text-sm">7210</td>
                        <td class="px-4 md:px-6 py-4 text-zinc-50 font-semibold text-sm">$7.99</td>
                    </tr>

                    <tr class=" hover:bg-bg-primary/60 transition-colors">
                        <td class="px-4 md:px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg ">
                                    <img src="{{ asset('assets/images/order.png') }}" alt="Fortnite Logo" class="w-full h-full rounded-lg" />
                                </div>
                                <div class="min-w-0">
                                    <h3 class="font-semibold text-zinc-50 text-sm md:text-base">Apex Legends Batt...
                                    </h3>
                                    <p class="text-xs text-red-400 truncate">Exclusive +60% Off</p>
                                    <a href="#"
                                        class="text-pink-400 text-xs hover:underline flex items-center gap-1">Discover
                                        more →</a>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 md:px-6 py-4 text-zinc-100 text-sm">Passes</td>
                        <td class="px-4 md:px-6 py-4 text-zinc-100 text-sm">Lara Croft</td>
                        <td class="px-4 md:px-6 py-4 text-zinc-100 text-sm whitespace-nowrap">January 15, 2019</td>
                        <td class="px-4 md:px-6 py-4">
                            <span
                                class="px-3 py-1 text-xs font-semibold rounded-full bg-primary-800 text-red-400 whitespace-nowrap inline-block">In
                                Progress</span>
                        </td>
                        <td class="px-4 md:px-6 py-4 text-zinc-100 text-sm">11567</td>
                        <td class="px-4 md:px-6 py-4 text-zinc-50 font-semibold text-sm">$8.50</td>
                    </tr>

                    <tr class="bg-bg-primary hover:bg-bg-primary/60 transition-colors">
                        <td class="px-4 md:px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-orange-600 flex-shrink-0">
                                    <img src="{{ asset('assets/images/order.png') }}" alt="Fortnite Logo" class="w-full h-full rounded-lg" />
                                </div>
                                <div class="min-w-0">
                                    <h3 class="font-semibold text-zinc-50 text-sm md:text-base">Call of Duty Skin P...
                                    </h3>
                                    <p class="text-xs text-pink-400 truncate">Limited Time +50% Savi...</p>
                                    <a href="#"
                                        class="text-pink-400 text-xs hover:underline flex items-center gap-1">View
                                        details →</a>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 md:px-6 py-4 text-zinc-100 text-sm">Bundles</td>
                        <td class="px-4 md:px-6 py-4 text-zinc-100 text-sm">John Doe</td>
                        <td class="px-4 md:px-6 py-4 text-zinc-100 text-sm whitespace-nowrap">March 10, 2026</td>
                        <td class="px-4 md:px-6 py-4">
                            <span
                                class="px-3 py-1 text-xs font-semibold rounded-full bg-primary-800 text-pink-400 whitespace-nowrap inline-block">Pending</span>
                        </td>
                        <td class="px-4 md:px-6 py-4 text-zinc-100 text-sm">3024</td>
                        <td class="px-4 md:px-6 py-4 text-zinc-50 font-semibold text-sm">$11.75</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="flex flex-wrap items-center justify-end mt-8 text-sm gap-2">
            <button
                class="px-3 md:px-4 py-2 bg-bg-tertiary-dark text-zinc-100 rounded-lg text-sm hover:bg-bg-primary/60 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">Previous</button>
            <button
                class="px-3 md:px-4 py-2 bg-zinc-500 text-white rounded-lg text-sm font-semibold shadow-lg shadow-primary-900/50 hover:bg-primary-600 transition-colors">1</button>
            <button
                class="px-3 md:px-4 py-2 bg-bg-tertiary-dark text-zinc-100 rounded-lg text-sm hover:bg-bg-primary/60 transition-colors">2</button>
            <button
                class="px-3 md:px-4 py-2 bg-bg-tertiary-dark text-zinc-100 rounded-lg text-sm hover:bg-bg-primary/60 transition-colors">3</button>
            <button
                class="px-3 md:px-4 py-2 bg-bg-tertiary-dark text-zinc-100 rounded-lg text-sm hover:bg-bg-primary/60 transition-colors">4</button>
            <button
                class="px-3 md:px-4 py-2 bg-bg-tertiary-dark text-zinc-100 rounded-lg text-sm hover:bg-bg-primary/60 transition-colors">5</button>
            <button
                class="px-3 md:px-4 py-2 bg-bg-tertiary-dark text-zinc-100 rounded-lg text-sm hover:bg-bg-primary/60 transition-colors">Next</button>
        </div>
    </div>
</div>
