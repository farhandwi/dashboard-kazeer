// resources/js/Pages/Subscription/CreateMerchant.jsx
import React, { useState } from 'react';
import { Head, useForm } from '@inertiajs/react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Button } from '@/Components/ui/button';
import { Input } from '@/Components/ui/input';
import { Label } from '@/Components/ui/label';
import { Card, CardContent, CardHeader, CardTitle } from '@/Components/ui/card';
import { 
    Building, 
    User, 
    Mail, 
    Phone, 
    MapPin, 
    Home 
} from 'lucide-react';

export default function CreateMerchant({ auth }) {
    const { data, setData, post, processing, errors } = useForm({
        name: '',
        business_name: '',
        email: auth.user.email, // Pre-fill dengan email user
        phone_number: '',
        address: '',
        city: '',
        province: '',
        postal_code: '',
        description: ''
    });

    const handleSubmit = (e) => {
        e.preventDefault();
        post(route('subscription.store-merchant'));
    };

    return (
        <AuthenticatedLayout user={auth.user}>
            <Head title="Buat Profil Merchant" />

            <div className="py-12">
                <div className="max-w-2xl mx-auto sm:px-6 lg:px-8">
                    <Card>
                        <CardHeader>
                            <CardTitle className="text-2xl">
                                Lengkapi Profil Merchant Anda
                            </CardTitle>
                        </CardHeader>
                        <CardContent>
                            <form onSubmit={handleSubmit} className="space-y-4">
                                <div className="grid md:grid-cols-2 gap-4">
                                    <div>
                                        <Label className="flex items-center">
                                            <User className="mr-2 h-4 w-4" /> Nama Pemilik
                                        </Label>
                                        <Input 
                                            value={data.name}
                                            onChange={(e) => setData('name', e.target.value)}
                                            placeholder="Nama pemilik restoran"
                                            required
                                            className={errors.name ? 'border-red-500' : ''}
                                        />
                                        {errors.name && (
                                            <p className="text-red-500 text-sm mt-1">{errors.name}</p>
                                        )}
                                    </div>

                                    <div>
                                        <Label className="flex items-center">
                                            <Building className="mr-2 h-4 w-4" /> Nama Bisnis
                                        </Label>
                                        <Input 
                                            value={data.business_name}
                                            onChange={(e) => setData('business_name', e.target.value)}
                                            placeholder="Nama restoran/bisnis"
                                            required
                                            className={errors.business_name ? 'border-red-500' : ''}
                                        />
                                        {errors.business_name && (
                                            <p className="text-red-500 text-sm mt-1">{errors.business_name}</p>
                                        )}
                                    </div>
                                </div>

                                <div className="grid md:grid-cols-2 gap-4">
                                    <div>
                                        <Label className="flex items-center">
                                            <Mail className="mr-2 h-4 w-4" /> Email
                                        </Label>
                                        <Input 
                                            type="email"
                                            value={data.email}
                                            onChange={(e) => setData('email', e.target.value)}
                                            placeholder="Email bisnis"
                                            required
                                            className={errors.email ? 'border-red-500' : ''}
                                        />
                                        {errors.email && (
                                            <p className="text-red-500 text-sm mt-1">{errors.email}</p>
                                        )}
                                    </div>

                                    <div>
                                        <Label className="flex items-center">
                                            <Phone className="mr-2 h-4 w-4" /> Nomor Telepon
                                        </Label>
                                        <Input 
                                            value={data.phone_number}
                                            onChange={(e) => setData('phone_number', e.target.value)}
                                            placeholder="Nomor telepon bisnis"
                                            required
                                            className={errors.phone_number ? 'border-red-500' : ''}
                                        />
                                        {errors.phone_number && (
                                            <p className="text-red-500 text-sm mt-1">{errors.phone_number}</p>
                                        )}
                                    </div>
                                </div>

                                <div>
                                    <Label className="flex items-center">
                                        <Home className="mr-2 h-4 w-4" /> Alamat
                                    </Label>
                                    <Input 
                                        value={data.address}
                                        onChange={(e) => setData('address', e.target.value)}
                                        placeholder="Alamat lengkap restoran"
                                        required
                                        className={errors.address ? 'border-red-500' : ''}
                                    />
                                    {errors.address && (
                                        <p className="text-red-500 text-sm mt-1">{errors.address}</p>
                                    )}
                                </div>

                                <div className="grid md:grid-cols-3 gap-4">
                                    <div>
                                        <Label className="flex items-center">
                                            <MapPin className="mr-2 h-4 w-4" /> Kota
                                        </Label>
                                        <Input 
                                            value={data.city}
                                            onChange={(e) => setData('city', e.target.value)}
                                            placeholder="Kota"
                                            required
                                            className={errors.city ? 'border-red-500' : ''}
                                        />
                                        {errors.city && (
                                            <p className="text-red-500 text-sm mt-1">{errors.city}</p>
                                        )}
                                    </div>

                                    <div>
                                        <Label>Provinsi</Label>
                                        <Input 
                                            value={data.province}
                                            onChange={(e) => setData('province', e.target.value)}
                                            placeholder="Provinsi"
                                            className={errors.province ? 'border-red-500' : ''}
                                        />
                                        {errors.province && (
                                            <p className="text-red-500 text-sm mt-1">{errors.province}</p>
                                        )}
                                    </div>

                                    <div>
                                        <Label>Kode Pos</Label>
                                        <Input 
                                            value={data.postal_code}
                                            onChange={(e) => setData('postal_code', e.target.value)}
                                            placeholder="Kode Pos"
                                            className={errors.postal_code ? 'border-red-500' : ''}
                                        />
                                        {errors.postal_code && (
                                            <p className="text-red-500 text-sm mt-1">{errors.postal_code}</p>
                                        )}
                                    </div>
                                </div>

                                <div>
                                    <Label>Deskripsi Restoran (Opsional)</Label>
                                    <textarea 
                                        value={data.description}
                                        onChange={(e) => setData('description', e.target.value)}
                                        placeholder="Ceritakan sedikit tentang restoran Anda"
                                        className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        rows="4"
                                    />
                                </div>

                                <div className="flex justify-end">
                                    <Button 
                                        type="submit" 
                                        disabled={processing}
                                    >
                                        {processing ? 'Menyimpan...' : 'Simpan Profil Merchant'}
                                    </Button>
                                </div>
                            </form>
                        </CardContent>
                    </Card>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}