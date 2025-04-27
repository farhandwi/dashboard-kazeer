import { Head, useForm, Link } from '@inertiajs/react';
import React from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { 
    Card, 
    CardContent, 
    CardHeader, 
    CardTitle 
} from '@/Components/ui/card';
import { Button } from '@/Components/ui/button';
import { Input } from '@/Components/ui/input';
import { Label } from '@/Components/ui/label';
import { Textarea } from '@/Components/ui/textarea';
import { 
    Tabs, 
    TabsContent, 
    TabsList, 
    TabsTrigger 
} from '@/Components/ui/tabs';
import { PlusCircle, MoreHorizontal } from 'lucide-react';
import { 
    DropdownMenu, 
    DropdownMenuContent, 
    DropdownMenuItem, 
    DropdownMenuTrigger 
} from '@/Components/ui/dropdown-menu';
import { router } from '@inertiajs/react';

export default function EditMerchant({ auth, merchant, outlets }) {
    const { data, setData, put, processing, errors } = useForm({
        name: merchant.name || '',
        business_name: merchant.business_name || '',
        email: merchant.email || '',
        phone_number: merchant.phone_number || '',
        address: merchant.address || '',
        city: merchant.city || '',
        province: merchant.province || '',
        postal_code: merchant.postal_code || '',
        description: merchant.description || '',
        website: merchant.website || '',
        social_media: merchant.social_media || {
            instagram: '',
            facebook: '',
            twitter: ''
        }
    });

    const handleSubmit = (e) => {
        e.preventDefault();
        put(route('merchants.update', merchant.id));
    };

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                    Edit Merchant: {merchant.business_name}
                </h2>
            }
        >
            <Head title={`Edit Merchant - ${merchant.business_name}`} />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <Tabs defaultValue="merchant-info">
                        <TabsList className="grid w-full grid-cols-2 mb-4">
                            <TabsTrigger value="merchant-info">Merchant Information
                            </TabsTrigger>
                            <TabsTrigger value="merchant-outlets">
                                Merchant Outlets
                            </TabsTrigger>
                        </TabsList>

                        <TabsContent value="merchant-info">
                            <Card>
                                <CardHeader>
                                    <CardTitle>Edit Merchant Details</CardTitle>
                                </CardHeader>
                                <CardContent>
                                    <form onSubmit={handleSubmit} className="space-y-4">
                                        <div className="grid md:grid-cols-2 gap-4">
                                            <div>
                                                <Label>Name</Label>
                                                <Input 
                                                    type="text"
                                                    value={data.name}
                                                    onChange={(e) => setData('name', e.target.value)}
                                                    className={errors.name ? 'border-red-500' : ''}
                                                />
                                                {errors.name && (
                                                    <p className="text-red-500 text-sm mt-1">{errors.name}</p>
                                                )}
                                            </div>
                                            <div>
                                                <Label>Business Name</Label>
                                                <Input 
                                                    type="text"
                                                    value={data.business_name}
                                                    onChange={(e) => setData('business_name', e.target.value)}
                                                    className={errors.business_name ? 'border-red-500' : ''}
                                                />
                                                {errors.business_name && (
                                                    <p className="text-red-500 text-sm mt-1">{errors.business_name}</p>
                                                )}
                                            </div>
                                        </div>

                                        <div className="grid md:grid-cols-2 gap-4">
                                            <div>
                                                <Label>Email</Label>
                                                <Input 
                                                    type="email"
                                                    value={data.email}
                                                    onChange={(e) => setData('email', e.target.value)}
                                                    className={errors.email ? 'border-red-500' : ''}
                                                />
                                                {errors.email && (
                                                    <p className="text-red-500 text-sm mt-1">{errors.email}</p>
                                                )}
                                            </div>
                                            <div>
                                                <Label>Phone Number</Label>
                                                <Input 
                                                    type="text"
                                                    value={data.phone_number}
                                                    onChange={(e) => setData('phone_number', e.target.value)}
                                                    className={errors.phone_number ? 'border-red-500' : ''}
                                                />
                                                {errors.phone_number && (
                                                    <p className="text-red-500 text-sm mt-1">{errors.phone_number}</p>
                                                )}
                                            </div>
                                        </div>

                                        <div className="grid md:grid-cols-3 gap-4">
                                            <div>
                                                <Label>City</Label>
                                                <Input 
                                                    type="text"
                                                    value={data.city}
                                                    onChange={(e) => setData('city', e.target.value)}
                                                    className={errors.city ? 'border-red-500' : ''}
                                                />
                                                {errors.city && (
                                                    <p className="text-red-500 text-sm mt-1">{errors.city}</p>
                                                )}
                                            </div>
                                            <div>
                                                <Label>Province</Label>
                                                <Input 
                                                    type="text"
                                                    value={data.province}
                                                    onChange={(e) => setData('province', e.target.value)}
                                                    className={errors.province ? 'border-red-500' : ''}
                                                />
                                                {errors.province && (
                                                    <p className="text-red-500 text-sm mt-1">{errors.province}</p>
                                                )}
                                            </div>
                                            <div>
                                                <Label>Postal Code</Label>
                                                <Input 
                                                    type="text"
                                                    value={data.postal_code}
                                                    onChange={(e) => setData('postal_code', e.target.value)}
                                                    className={errors.postal_code ? 'border-red-500' : ''}
                                                />
                                                {errors.postal_code && (
                                                    <p className="text-red-500 text-sm mt-1">{errors.postal_code}</p>
                                                )}
                                            </div>
                                        </div>

                                        <div>
                                            <Label>Address</Label>
                                            <Textarea 
                                                value={data.address}
                                                onChange={(e) => setData('address', e.target.value)}
                                                className={errors.address ? 'border-red-500' : ''}
                                            />
                                            {errors.address && (
                                                <p className="text-red-500 text-sm mt-1">{errors.address}</p>
                                            )}
                                        </div>

                                        <div>
                                            <Label>Description</Label>
                                            <Textarea 
                                                value={data.description}
                                                onChange={(e) => setData('description', e.target.value)}
                                                className={errors.description ? 'border-red-500' : ''}
                                            />
                                            {errors.description && (
                                                <p className="text-red-500 text-sm mt-1">{errors.description}</p>
                                            )}
                                        </div>

                                        <div className="grid md:grid-cols-2 gap-4">
                                            <div>
                                                <Label>Website</Label>
                                                <Input 
                                                    type="text"
                                                    value={data.website}
                                                    onChange={(e) => setData('website', e.target.value)}
                                                    className={errors.website ? 'border-red-500' : ''}
                                                />
                                                {errors.website && (
                                                    <p className="text-red-500 text-sm mt-1">{errors.website}</p>
                                                )}
                                            </div>
                                            <div>
                                                <Label>Social Media</Label>
                                                <div className="grid grid-cols-3 gap-2">
                                                    <Input 
                                                        type="text"
                                                        placeholder="Instagram"
                                                        value={data.social_media.instagram}
                                                        onChange={(e) => setData('social_media', {
                                                            ...data.social_media, 
                                                            instagram: e.target.value
                                                        })}
                                                    />
                                                    <Input 
                                                        type="text"
                                                        placeholder="Facebook"
                                                        value={data.social_media.facebook}
                                                        onChange={(e) => setData('social_media', {
                                                            ...data.social_media, 
                                                            facebook: e.target.value
                                                        })}
                                                    />
                                                    <Input 
                                                        type="text"
                                                        placeholder="Twitter"
                                                        value={data.social_media.twitter}
                                                        onChange={(e) => setData('social_media', {
                                                            ...data.social_media, 
                                                            twitter: e.target.value
                                                        })}
                                                    />
                                                </div>
                                            </div>
                                        </div>

                                        <div className="flex justify-end space-x-4 mt-6">
                                            <Link href={route('merchants.index')}>
                                                <Button type="button" variant="outline">
                                                    Cancel
                                                </Button>
                                            </Link>
                                            <Button 
                                                type="submit" 
                                                disabled={processing}
                                            >
                                                {processing ? 'Updating...' : 'Update Merchant'}
                                            </Button>
                                        </div>
                                    </form>
                                </CardContent>
                            </Card>
                        </TabsContent>

                        <TabsContent value="merchant-outlets">
                            <Card>
                                <CardHeader className="flex flex-row justify-between items-center">
                                    <CardTitle>Merchant Outlets</CardTitle>
                                    <Link href={route('merchants.outlets.create', merchant.id)}>
                                        <Button variant="default" size="sm">
                                            <PlusCircle className="mr-2 h-4 w-4" /> 
                                            Add New Outlet
                                        </Button>
                                    </Link>
                                </CardHeader>
                                <CardContent>
                                    <Table>
                                        <TableHeader>
                                            <TableRow>
                                                <TableHead>Name</TableHead>
                                                <TableHead>Address</TableHead>
                                                <TableHead>City</TableHead>
                                                <TableHead>Phone</TableHead>
                                                <TableHead>Status</TableHead>
                                                <TableHead>Actions</TableHead>
                                            </TableRow>
                                        </TableHeader>
                                        <TableBody>
                                            {outlets.map((outlet) => (
                                                <TableRow key={outlet.id}>
                                                    <TableCell>{outlet.name}</TableCell>
                                                    <TableCell>{outlet.address}</TableCell>
                                                    <TableCell>{outlet.city}</TableCell>
                                                    <TableCell>{outlet.phone_number}</TableCell>
                                                    <TableCell>
                                                        <span className={`px-2 py-1 rounded ${
                                                            outlet.status === 'active' 
                                                            ? 'bg-green-100 text-green-800' 
                                                            : 'bg-red-100 text-red-800'
                                                        }`}>
                                                            {outlet.status}
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
                                                                        href={route('merchants.outlets.edit', [merchant.id, outlet.id])}
                                                                        className="w-full"
                                                                    >
                                                                        Edit
                                                                    </Link>
                                                                </DropdownMenuItem>
                                                                <DropdownMenuItem 
                                                                    onClick={() => {
                                                                        if (confirm('Are you sure you want to delete this outlet?')) {
                                                                            router.delete(route('merchants.outlets.destroy', [merchant.id, outlet.id]));
                                                                        }
                                                                    }}
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
                        </TabsContent>
                    </Tabs>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}