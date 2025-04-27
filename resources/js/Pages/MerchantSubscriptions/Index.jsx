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
    Eye 
} from 'lucide-react';

export default function MerchantSubscriptionIndex() {
    const { merchantSubscriptions, filters, auth } = usePage().props;
    const [search, setSearch] = useState(filters.search || '');

    const handleSearch = (e) => {
        e.preventDefault();
        router.get(route('merchant-subscriptions.index'), { search }, {
            preserveState: true,
            replace: true
        });
    };

    // Format mata uang
    const formatCurrency = (amount) => {
        return new Intl.NumberFormat('id-ID', { 
            style: 'currency', 
            currency: 'IDR' 
        }).format(amount || 0);
    };

    // Status warna berdasarkan status subscription
    const getStatusColor = (status) => {
        switch(status) {
            case 'active':
                return 'bg-green-100 text-green-800';
            case 'expired':
                return 'bg-red-100 text-red-800';
            case 'cancelled':
                return 'bg-gray-100 text-gray-800';
            default:
                return 'bg-yellow-100 text-yellow-800';
        }
    };

    // Hitung sisa hari berlangganan
    const calculateRemainingDays = (endDate) => {
        if (!endDate) return 0;
        const end = new Date(endDate);
        const now = new Date();
        const difference = end.getTime() - now.getTime();
        return Math.max(0, Math.ceil(difference / (1000 * 3600 * 24)));
    };

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <div className="flex justify-between items-center">
                    <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                        Merchant Subscriptions Management
                    </h2>
                </div>
            }
        >
            <Head title="Merchant Subscriptions" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <Tabs defaultValue="list">
                        <TabsList>
                            <TabsTrigger value="list">Subscription List</TabsTrigger>
                            <TabsTrigger value="analytics">Analytics</TabsTrigger>
                        </TabsList>

                        <TabsContent value="list">
                            <Card>
                                <CardHeader>
                                    <CardTitle>Merchant Subscriptions</CardTitle>
                                </CardHeader>
                                <CardContent>
                                    <form onSubmit={handleSearch} className="mb-4">
                                        <div className="flex">
                                            <Input 
                                                type="text" 
                                                placeholder="Search by merchant name..." 
                                                value={search}
                                                onChange={(e) => setSearch(e.target.value)}
                                                className="mr-2"
                                            />
                                            <Button type="submit">Search</Button>
                                        </div>
                                    </form>

                                    {merchantSubscriptions.data.length === 0 ? (
                                        <div className="text-center py-6 text-gray-500">
                                            No merchant subscriptions found.
                                        </div>
                                    ) : (
                                        <Table>
                                            <TableHeader>
                                                <TableRow>
                                                    <TableHead>Merchant</TableHead>
                                                    <TableHead>Subscription Plan</TableHead>
                                                    <TableHead>Price</TableHead>
                                                    <TableHead>Start Date</TableHead>
                                                    <TableHead>End Date</TableHead>
                                                    <TableHead>Remaining Days</TableHead>
                                                    <TableHead>Status</TableHead>
                                                    <TableHead>Actions</TableHead>
                                                </TableRow>
                                            </TableHeader>
                                            <TableBody>
                                                {merchantSubscriptions.data.map((subscription) => (
                                                    <TableRow key={subscription.id}>
                                                        <TableCell>
                                                            {subscription.merchant?.business_name || 'N/A'}
                                                        </TableCell>
                                                        <TableCell>
                                                            {subscription.subscription_plan?.name || 'N/A'}
                                                        </TableCell>
                                                        <TableCell>
                                                            {formatCurrency(subscription.subscription_plan?.price)}
                                                        </TableCell>
                                                        <TableCell>
                                                            {subscription.start_date 
                                                                ? new Date(subscription.start_date).toLocaleDateString() 
                                                                : 'N/A'}
                                                        </TableCell>
                                                        <TableCell>
                                                            {subscription.end_date 
                                                                ? new Date(subscription.end_date).toLocaleDateString() 
                                                                : 'N/A'}
                                                        </TableCell>
                                                        <TableCell>
                                                            {calculateRemainingDays(subscription.end_date)} days
                                                        </TableCell>
                                                        <TableCell>
                                                            <span className={`
                                                                px-2 py-1 rounded text-xs
                                                                ${getStatusColor(subscription.status)}
                                                            `}>
                                                                {subscription.status || 'N/A'}
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
                                                                    <DropdownMenuItem>
                                                                        <Button 
                                                                            variant="ghost" 
                                                                            size="sm" 
                                                                            className="w-full"
                                                                            onClick={() => router.visit(route('merchant-subscriptions.show', subscription.id))}
                                                                        >
                                                                            <Eye className="mr-2 h-4 w-4" /> View Details
                                                                        </Button>
                                                                    </DropdownMenuItem>
                                                                </DropdownMenuContent>
                                                            </DropdownMenu>
                                                        </TableCell>
                                                    </TableRow>
                                                ))}
                                            </TableBody>
                                        </Table>
                                    )}

                                    {/* Pagination */}
                                    {merchantSubscriptions.data.length > 0 && (
                                        <div className="mt-4 flex justify-between items-center">
                                            <div className="text-sm text-gray-600">
                                                Showing {merchantSubscriptions.from} to {merchantSubscriptions.to} of {merchantSubscriptions.total} entries
                                            </div>
                                            <div className="flex space-x-2">
                                                {merchantSubscriptions.links.map((link, index) => (
                                                    <Button
                                                        key={index}
                                                        variant={link.active ? 'default' : 'outline'}
                                                        onClick={() => link.url && router.visit(link.url)}
                                                        disabled={!link.url}
                                                        className={link.url ? '' : 'cursor-not-allowed opacity-50'}
                                                    >
                                                        <span dangerouslySetInnerHTML={{ __html: link.label }} />
                                                    </Button>
                                                ))}
                                            </div>
                                        </div>
                                    )}
                                </CardContent>
                            </Card>
                        </TabsContent>

                        <TabsContent value="analytics">
                            <Card>
                                <CardHeader>
                                    <CardTitle>Subscription Analytics</CardTitle>
                                </CardHeader>
                                <CardContent>
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