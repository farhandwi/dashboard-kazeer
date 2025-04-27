// resources/js/Pages/SubscriptionPayments/Index.jsx
import React, { useState } from 'react';
import { Link, router } from '@inertiajs/react'; // Pastikan import benar
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

export default function SubscriptionPaymentIndex({ 
    payments, 
    filters, 
    auth 
}) {
    const [search, setSearch] = useState(filters.search || '');

    const handleSearch = (e) => {
        e.preventDefault();
        router.get(route('subscription-payments.index'), { search }, {
            preserveState: true,
            replace: true
        });
    };

    // Format mata uang
    const formatCurrency = (amount) => {
        return new Intl.NumberFormat('id-ID', { 
            style: 'currency', 
            currency: 'IDR' 
        }).format(amount);
    };

    // Warna status pembayaran
    const getStatusColor = (status) => {
        switch(status) {
            case 'success':
                return 'bg-green-100 text-green-800';
            case 'pending':
                return 'bg-yellow-100 text-yellow-800';
            case 'failed':
                return 'bg-red-100 text-red-800';
            default:
                return 'bg-gray-100 text-gray-800';
        }
    };

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <div className="flex justify-between items-center">
                    <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                        Subscription Payments Management
                    </h2>
                </div>
            }
        >
            <Head title="Subscription Payments" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <Tabs defaultValue="list">
                        <TabsList>
                            <TabsTrigger value="list">Payment List</TabsTrigger>
                            <TabsTrigger value="analytics">Analytics</TabsTrigger>
                        </TabsList>

                        <TabsContent value="list">
                            <Card>
                                <CardHeader>
                                    <CardTitle>Subscription Payment Transactions</CardTitle>
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

                                    <Table>
                                        <TableHeader>
                                            <TableRow>
                                                <TableHead>Transaction ID</TableHead>
                                                <TableHead>Merchant</TableHead>
                                                <TableHead>Plan</TableHead>
                                                <TableHead>Amount</TableHead>
                                                <TableHead>Payment Gateway</TableHead>
                                                <TableHead>Status</TableHead>
                                                <TableHead>Date</TableHead>
                                                <TableHead>Actions</TableHead>
                                            </TableRow>
                                        </TableHeader>
                                        <TableBody>
                                            {payments.data.map((payment) => (
                                                <TableRow key={payment.id}>
                                                    <TableCell>{payment.id}</TableCell>
                                                    <TableCell>
                                                        {payment.merchant_subscription?.merchant?.business_name || 'N/A'}
                                                    </TableCell>
                                                    <TableCell>
                                                        {payment.merchant_subscription?.subscription_plan?.name || 'N/A'}
                                                    </TableCell>
                                                    <TableCell>
                                                        {formatCurrency(payment.amount)}
                                                    </TableCell>
                                                    <TableCell>{payment.payment_gateway}</TableCell>
                                                    <TableCell>
                                                        <span className={`
                                                            px-2 py-1 rounded text-xs
                                                            ${getStatusColor(payment.status)}
                                                        `}>
                                                            {payment.status}
                                                        </span>
                                                    </TableCell>
                                                    <TableCell>
                                                        {new Date(payment.created_at).toLocaleDateString()}
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
                                                                        onClick={() => router.visit(route('subscription-payments.show', payment.id))}
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

                                    {/* Pagination */}
                                    <div className="mt-4 flex justify-between items-center">
                                        <div className="text-sm text-gray-600">
                                            Showing {payments.from} to {payments.to} of {payments.total} entries
                                        </div>
                                        <div className="flex space-x-2">
                                            {payments.links.map((link, index) => (
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
                                </CardContent>
                            </Card>
                        </TabsContent>

                        <TabsContent value="analytics">
                            <Card>
                                <CardHeader>
                                    <CardTitle>Payment Analytics</CardTitle>
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