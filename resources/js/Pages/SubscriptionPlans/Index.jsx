import React, { useState } from 'react';
import { Link, router, usePage } from '@inertiajs/react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';
import { Button } from '@/Components/ui/button';
import { Input } from '@/Components/ui/input';
import { 
    Table, 
    TableBody, 
    TableCell, 
    TableHead, 
    TableHeader, 
    TableRow 
} from '@/Components/ui/table';
import { 
    Card, 
    CardContent, 
    CardHeader, 
    CardTitle 
} from '@/Components/ui/card';
import { 
    DropdownMenu, 
    DropdownMenuContent, 
    DropdownMenuItem, 
    DropdownMenuTrigger 
} from '@/Components/ui/dropdown-menu';
import { 
    Tabs, 
    TabsContent, 
    TabsList, 
    TabsTrigger 
} from '@/Components/ui/tabs';
import { 
    MoreHorizontal, 
    PlusCircle, 
    Edit, 
    Trash2 
} from 'lucide-react';

export default function SubscriptionPlanIndex() {
    const { plans, filters, auth } = usePage().props;
    const [search, setSearch] = useState(filters.search || '');

    const handleSearch = (e) => {
        e.preventDefault();
        router.get(route('subscription-plans.index'), { search }, {
            preserveState: true,
            replace: true
        });
    };

    const handleDelete = (id) => {
        if (confirm('Are you sure you want to delete this subscription plan?')) {
            router.delete(route('subscription-plans.destroy', id));
        }
    };

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <div className="flex justify-between items-center">
                    <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                        Subscription Plans Management
                    </h2>
                    <Link 
                        href={route('subscription-plans.create')} 
                        method="get"
                        as="button"
                    >
                        <Button variant="default" size="sm">
                            <PlusCircle className="mr-2 h-4 w-4" /> 
                            Add New Plan
                        </Button>
                    </Link>
                </div>
            }
        >
            <Head title="Subscription Plans Management" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <Tabs defaultValue="list">
                        <TabsList>
                            <TabsTrigger value="list">Subscription Plans</TabsTrigger>
                            <TabsTrigger value="analytics">Analytics</TabsTrigger>
                        </TabsList>

                        <TabsContent value="list">
                            <Card>
                                <CardHeader>
                                    <CardTitle>Subscription Plans List</CardTitle>
                                </CardHeader>
                                <CardContent>
                                    <form onSubmit={handleSearch} className="mb-4">
                                        <div className="flex">
                                            <Input 
                                                type="text" 
                                                placeholder="Search plans..." 
                                                value={search}
                                                onChange={(e) => setSearch(e.target.value)}
                                                className="mr-2"
                                            />
                                            <Button type="submit">Search</Button>
                                        </div>
                                    </form>

                                    <Table>
                                        <TableHeader>
                                            <TableRow>
                                                <TableHead>Name</TableHead>
                                                <TableHead>Description</TableHead>
                                                <TableHead>Price</TableHead>
                                                <TableHead>Duration</TableHead>
                                                <TableHead>Status</TableHead>
                                                <TableHead>Actions</TableHead>
                                            </TableRow>
                                        </TableHeader>
                                        <TableBody>
                                            {plans.data.map((plan) => (
                                                <TableRow key={plan.id}>
                                                    <TableCell>{plan.name}</TableCell>
                                                    <TableCell>{plan.description}</TableCell>
                                                    <TableCell>
                                                        {new Intl.NumberFormat('id-ID', { 
                                                            style: 'currency', 
                                                            currency: 'IDR' 
                                                        }).format(plan.price)}
                                                    </TableCell>
                                                    <TableCell>{plan.duration_days} days</TableCell>
                                                    <TableCell>
                                                        <span className={`
                                                            px-2 py-1 rounded text-xs
                                                            ${plan.is_active 
                                                                ? 'bg-green-100 text-green-800' 
                                                                : 'bg-red-100 text-red-800'
                                                            }
                                                        `}>
                                                            {plan.is_active ? 'Active' : 'Inactive'}
                                                        </span>
                                                    </TableCell>
                                                    <TableCell>
                                                        <DropdownMenu>
                                                            <DropdownMenuTrigger asChild>
                                                                <Button variant="ghost" size="sm">
                                                                    <MoreHorizontal className="h-4 w-4" />
                                                                </Button>
                                                            </DropdownMenuTrigger>
                                                            <DropdownMenuContent>
                                                                <DropdownMenuItem asChild>
                                                                    <Link 
                                                                        href={route('subscription-plans.edit', plan.id)}
                                                                        method="get"
                                                                        as="button"
                                                                        className="w-full flex items-center"
                                                                    >
                                                                        <Edit className="mr-2 h-4 w-4" /> Edit
                                                                    </Link>
                                                                </DropdownMenuItem>
                                                                <DropdownMenuItem 
                                                                    onClick={() => handleDelete(plan.id)}
                                                                    className="text-red-600 focus:text-red-800 flex items-center"
                                                                >
                                                                    <Trash2 className="mr-2 h-4 w-4" /> Delete
                                                                </DropdownMenuItem>
                                                            </DropdownMenuContent>
                                                        </DropdownMenu>
                                                    </TableCell>
                                                </TableRow>
                                            ))}
                                        </TableBody>
                                    </Table>
                                </CardContent>
                            </Card>
                        </TabsContent>

                        <TabsContent value="analytics">
                            <Card>
                                <CardHeader>
                                    <CardTitle>Subscription Plan Analytics</CardTitle>
                                </CardHeader>
                                <CardContent>
                                    {/* Tambahkan grafik atau statistik di sini */}
                                    <div className="text-center py-6 text-gray-500">
                                        Analytics coming soon
                                    </div>
                                </CardContent>
                            </Card>
                        </TabsContent>
                    </Tabs>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}