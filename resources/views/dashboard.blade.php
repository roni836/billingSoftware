<x-layouts.app>
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Dashboard</h1>
        <p class="text-gray-600">Welcome to the Motorcycle Service Center Dashboard</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-500 mr-4">
                    <i class="fas fa-tools text-2xl"></i>
                </div>
                <div>
                    <p class="text-gray-500">Total Spare Parts</p>
                    <p class="text-2xl font-bold">487</p>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-green-500 text-sm font-semibold">+12%</span>
                <span class="text-gray-500 text-sm">from last month</span>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-500 mr-4">
                    <i class="fas fa-cash-register text-2xl"></i>
                </div>
                <div>
                    <p class="text-gray-500">Today's Sales</p>
                    <p class="text-2xl font-bold">₹18,245</p>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-green-500 text-sm font-semibold">+5%</span>
                <span class="text-gray-500 text-sm">from yesterday</span>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-500 mr-4">
                    <i class="fas fa-wrench text-2xl"></i>
                </div>
                <div>
                    <p class="text-gray-500">Pending Services</p>
                    <p class="text-2xl font-bold">12</p>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-red-500 text-sm font-semibold">+3</span>
                <span class="text-gray-500 text-sm">from yesterday</span>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-500 mr-4">
                    <i class="fas fa-users text-2xl"></i>
                </div>
                <div>
                    <p class="text-gray-500">Total Customers</p>
                    <p class="text-2xl font-bold">356</p>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-green-500 text-sm font-semibold">+8%</span>
                <span class="text-gray-500 text-sm">from last month</span>
            </div>
        </div>
    </div>

    <!-- Recent Activity and Inventory Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Recent Activity -->
        <div class="bg-white rounded-lg shadow">
            <div class="border-b px-6 py-4">
                <h2 class="font-bold text-lg">Recent Activity</h2>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <div class="flex items-start">
                        <div class="p-2 rounded-full bg-blue-100 text-blue-500 mr-4">
                            <i class="fas fa-wrench"></i>
                        </div>
                        <div>
                            <p class="font-medium">Service Completed</p>
                            <p class="text-sm text-gray-500">Honda CBR - Engine Tuning</p>
                            <p class="text-xs text-gray-400">10 minutes ago</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="p-2 rounded-full bg-green-100 text-green-500 mr-4">
                            <i class="fas fa-cash-register"></i>
                        </div>
                        <div>
                            <p class="font-medium">New Sale</p>
                            <p class="text-sm text-gray-500">₹4,250 - Brake Pads and Labor</p>
                            <p class="text-xs text-gray-400">45 minutes ago</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="p-2 rounded-full bg-purple-100 text-purple-500 mr-4">
                            <i class="fas fa-user"></i>
                        </div>
                        <div>
                            <p class="font-medium">New Customer</p>
                            <p class="text-sm text-gray-500">Rahul Sharma - Royal Enfield Classic 350</p>
                            <p class="text-xs text-gray-400">2 hours ago</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="p-2 rounded-full bg-yellow-100 text-yellow-500 mr-4">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <div>
                            <p class="font-medium">New Purchase</p>
                            <p class="text-sm text-gray-500">Ordered 25 Engine Oil Filters</p>
                            <p class="text-xs text-gray-400">3 hours ago</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Low Inventory Alert -->
        <div class="bg-white rounded-lg shadow">
            <div class="border-b px-6 py-4">
                <h2 class="font-bold text-lg">Low Inventory Alert</h2>
            </div>
            <div class="p-6">
                <table class="min-w-full">
                    <thead>
                        <tr>
                            <th class="text-left text-sm font-medium text-gray-500 pb-4">Part Name</th>
                            <th class="text-left text-sm font-medium text-gray-500 pb-4">Stock</th>
                            <th class="text-left text-sm font-medium text-gray-500 pb-4">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        <tr>
                            <td class="py-3">
                                <div class="flex items-center">
                                    <span class="font-medium">Brake Pads</span>
                                </div>
                            </td>
                            <td class="py-3">3 units</td>
                            <td class="py-3">
                                <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-600">Critical</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="py-3">
                                <div class="flex items-center">
                                    <span class="font-medium">Chain Lubricant</span>
                                </div>
                            </td>
                            <td class="py-3">5 units</td>
                            <td class="py-3">
                                <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-600">Low</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="py-3">
                                <div class="flex items-center">
                                    <span class="font-medium">Air Filters</span>
                                </div>
                            </td>
                            <td class="py-3">7 units</td>
                            <td class="py-3">
                                <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-600">Low</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="py-3">
                                <div class="flex items-center">
                                    <span class="font-medium">Clutch Plates</span>
                                </div>
                            </td>
                            <td class="py-3">4 units</td>
                            <td class="py-3">
                                <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-600">Critical</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Upcoming Services -->
    <div class="bg-white rounded-lg shadow mb-8">
        <div class="border-b px-6 py-4">
            <h2 class="font-bold text-lg">Upcoming Services</h2>
        </div>
        <div class="p-6">
            <table class="min-w-full">
                <thead>
                    <tr>
                        <th class="text-left text-sm font-medium text-gray-500 pb-4">Customer</th>
                        <th class="text-left text-sm font-medium text-gray-500 pb-4">Vehicle</th>
                        <th class="text-left text-sm font-medium text-gray-500 pb-4">Service Type</th>
                        <th class="text-left text-sm font-medium text-gray-500 pb-4">Date</th>
                        <th class="text-left text-sm font-medium text-gray-500 pb-4">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    <tr>
                        <td class="py-3">
                            <div class="flex items-center">
                                <span class="font-medium">Amit Patel</span>
                            </div>
                        </td>
                        <td class="py-3">TVS Apache RTR 160</td>
                        <td class="py-3">Regular Maintenance</td>
                        <td class="py-3">Today, 2:00 PM</td>
                        <td class="py-3">
                            <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-600">Confirmed</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="py-3">
                            <div class="flex items-center">
                                <span class="font-medium">Neha Singh</span>
                            </div>
                        </td>
                        <td class="py-3">Yamaha FZ</td>
                        <td class="py-3">Engine Work</td>
                        <td class="py-3">Today, 4:30 PM</td>
                        <td class="py-3">
                            <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-600">Confirmed</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="py-3">
                            <div class="flex items-center">
                                <span class="font-medium">Rajesh Kumar</span>
                            </div>
                        </td>
                        <td class="py-3">Royal Enfield Meteor</td>
                        <td class="py-3">Electrical Issue</td>
                        <td class="py-3">Tomorrow, 11:00 AM</td>
                        <td class="py-3">
                            <span class="px-2 py-1 text-xs rounded-full bg-purple-100 text-purple-600">Pending</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="py-3">
                            <div class="flex items-center">
                                <span class="font-medium">Priya Verma</span>
                            </div>
                        </td>
                        <td class="py-3">Suzuki Access 125</td>
                        <td class="py-3">Tire Replacement</td>
                        <td class="py-3">Tomorrow, 3:00 PM</td>
                        <td class="py-3">
                            <span class="px-2 py-1 text-xs rounded-full bg-purple-100 text-purple-600">Pending</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.app>