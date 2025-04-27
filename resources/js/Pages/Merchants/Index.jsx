import { Head, Link, router } from '@inertiajs/react';
import React, { useState } from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Button } from '@/Components/ui/button';
import { Input } from '@/Components/ui/input';
import { 
    Table, 
    TableBody, 
    TableCaption, 
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
import { MoreHorizontal, PlusCircle } from 'lucide-react';

export default function Index({ 
    auth, 
    merchants, 
    filters 
}) {
    console.log(filters, 'filters');
    console.log(merchants, 'merchants');
    console.log(auth, 'auth');

    const [search, setSearch] = useState(filters);

    const handleSearch = (e) => {
        e.preventDefault();
        router.get(route('merchants.index'), { search }, {
            preserveState: true,
            replace: true
        });
    };

    const handleDelete = (id) => {
        if (confirm('Are you sure you want to delete this merchant?')) {
            router.delete(route('merchants.destroy', id));
        }
    };

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <div className="flex justify-between items-center">
                    <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                        Merchants Management
                    </h2>
                    <Link href={route('merchants.create')}>
                        <Button variant="default" size="sm">
                            <PlusCircle className="mr-2 h-4 w-4" /> 
                            Add New Merchant
                        </Button>
                    </Link>
                </div>
            }
        >
            <Head title="Merchants Management" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <Card>
                        <CardHeader>
                            <CardTitle>Merchant List</CardTitle>
                        </CardHeader>
                        <CardContent>
                            <form onSubmit={handleSearch} className="mb-4">
                                <div className="flex">
                                    <Input 
                                        type="text" 
                                        placeholder="Search merchants..." 
                                        value={search}
                                        onChange={(e) => setSearch(e.target.value)}
                                        className="mr-2"
                                    />
                                    <Button type="submit">Search</Button>
                                </div>
                            </form>

                            <Table>
                                <TableCaption>List of all merchants</TableCaption>
                                <TableHeader>
                                    <TableRow>
                                        <TableHead>Name</TableHead>
                                        <TableHead>Business Name</TableHead>
                                        <TableHead>Email</TableHead>
                                        <TableHead>Phone</TableHead>
                                        <TableHead>Outlets</TableHead>
                                        <TableHead>Status</TableHead>
                                        <TableHead>Actions</TableHead>
                                    </TableRow>
                                </TableHeader>
                                <TableBody>
                                    {merchants.data.map((merchant) => (
                                        <TableRow key={merchant.id}>
                                            <TableCell>{merchant.name}</TableCell>
                                            <TableCell>{merchant.business_name}</TableCell>
                                            <TableCell>{merchant.email}</TableCell>
                                            <TableCell>{merchant.phone_number}</TableCell>
                                            <TableCell>{merchant.outlets_count}</TableCell>
                                            <TableCell>
                                                <span className={`px-2 py-1 rounded ${
                                                    merchant.status === 'active' 
                                                    ? 'bg-green-100 text-green-800' 
                                                    : 'bg-red-100 text-red-800'
                                                }`}>
                                                    {merchant.status}
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
                                                                href={route('merchants.outlets.index', merchant.id)}
                                                                className="w-full"
                                                            >
                                                                View Outlets
                                                            </Link>
                                                        </DropdownMenuItem>
                                                        <DropdownMenuItem asChild>
                                                            <Link 
                                                                href={route('merchants.edit', merchant.id)}
                                                                className="w-full"
                                                            >
                                                                Edit
                                                            </Link>
                                                        </DropdownMenuItem>
                                                        <DropdownMenuItem 
                                                            onClick={() => handleDelete(merchant.id)}
                                                            className="text-red-600 focus:text-red-800"
                                                        >
                                                            Delete
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
                        {/* Pagination */}
                        <div className="mt-4 flex justify-between items-center">
                        <div className="text-sm text-gray-600">
                            Showing {merchants.from} to {merchants.to} of {merchants.total} entries
                        </div>
                        <div className="flex space-x-2">
                        {merchants.links && merchants.links.map((link, index) => {
                            // Skip links with no URL to prevent errors
                            if (!link || !link.url) return null;
                            
                            return (
                                <Link 
                                    key={index} 
                                    href={link.url} 
                                    className={`px-3 py-1 border rounded ${
                                        link.active 
                                        ? 'bg-primary text-white' 
                                        : 'bg-white text-gray-700'
                                    } hover:bg-gray-100`}
                                    preserveState
                                    preserveScroll
                                >
                                    <span dangerouslySetInnerHTML={{ __html: link.label }} />
                                </Link>
                            );
                        })}
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
                    