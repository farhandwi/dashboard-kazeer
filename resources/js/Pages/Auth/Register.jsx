// resources/js/Pages/Auth/Register.jsx
import React from 'react';
import { Head, Link, useForm } from '@inertiajs/react';
import { Button } from '@/Components/ui/button';
import { Input } from '@/Components/ui/input';
import { Label } from '@/Components/ui/label';
import { Card, CardContent, CardHeader, CardTitle } from '@/Components/ui/card';
import { 
    User, 
    Mail, 
    Lock 
} from 'lucide-react';

export default function Register() {
    const { data, setData, post, processing, errors, reset } = useForm({
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
    });

    const submit = (e) => {
        e.preventDefault();

        post(route('register'), {
            onFinish: () => reset('password', 'password_confirmation'),
        });
    };

    return (
        <div className="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 to-blue-100">
            <Head title="Daftar Akun" />
            
            <Card className="w-full max-w-md shadow-2xl">
                <CardHeader className="text-center">
                    <CardTitle className="text-3xl font-bold text-blue-800">
                        Buat Akun Baru
                    </CardTitle>
                    <p className="text-gray-500 mt-2">
                        Mulai perjalanan kuliner Anda dengan Kazeer
                    </p>
                </CardHeader>
                <CardContent>
                    <form onSubmit={submit} className="space-y-4">
                        <div>
                            <Label htmlFor="name" className="flex items-center">
                                <User className="mr-2 h-4 w-4" /> Nama Lengkap
                            </Label>
                            <Input 
                                id="name"
                                type="text"
                                value={data.name}
                                onChange={(e) => setData('name', e.target.value)}
                                placeholder="Masukkan nama Anda"
                                required
                                className={errors.name ? 'border-red-500' : ''}
                            />
                            {errors.name && (
                                <p className="text-red-500 text-sm mt-1">{errors.name}</p>
                            )}
                        </div>

                        <div>
                            <Label htmlFor="email" className="flex items-center">
                                <Mail className="mr-2 h-4 w-4" /> Email
                            </Label>
                            <Input 
                                id="email"
                                type="email"
                                value={data.email}
                                onChange={(e) => setData('email', e.target.value)}
                                placeholder="Masukkan email Anda"
                                required
                                className={errors.email ? 'border-red-500' : ''}
                            />
                            {errors.email && (
                                <p className="text-red-500 text-sm mt-1">{errors.email}</p>
                            )}
                        </div>

                        <div>
                            <Label htmlFor="password" className="flex items-center">
                                <Lock className="mr-2 h-4 w-4" /> Password
                            </Label>
                            <Input 
                                id="password"
                                type="password"
                                value={data.password}
                                onChange={(e) => setData('password', e.target.value)}
                                placeholder="Buat password Anda"
                                required
                                className={errors.password ? 'border-red-500' : ''}
                            />
                            {errors.password && (
                                <p className="text-red-500 text-sm mt-1">{errors.password}</p>
                            )}
                        </div>

                        <div>
                            <Label htmlFor="password_confirmation" className="flex items-center">
                                <Lock className="mr-2 h-4 w-4" /> Konfirmasi Password
                            </Label>
                            <Input 
                                id="password_confirmation"
                                type="password"
                                value={data.password_confirmation}
                                onChange={(e) => setData('password_confirmation', e.target.value)}
                                placeholder="Ulangi password Anda"
                                required
                                className={errors.password_confirmation ? 'border-red-500' : ''}
                            />
                            {errors.password_confirmation && (
                                <p className="text-red-500 text-sm mt-1">{errors.password_confirmation}</p>
                            )}
                        </div>

                        <Button 
                            type="submit" 
                            className="w-full"
                            disabled={processing}
                        >
                            {processing ? 'Mendaftarkan...' : 'Daftar'}
                        </Button>

                        <div className="text-center mt-4">
                            <p className="text-sm text-gray-600">
                                Sudah punya akun? {' '}
                                <Link 
                                    href={route('login')} 
                                    className="text-blue-600 hover:underline"
                                >
                                    Masuk Sekarang
                                </Link>
                            </p>
                        </div>
                    </form>
                </CardContent>
            </Card>
        </div>
    );
}