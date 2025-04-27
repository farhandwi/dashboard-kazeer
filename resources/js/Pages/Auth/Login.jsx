import React, { useState } from 'react';
import { Head, Link, useForm } from '@inertiajs/react';
import { Button } from '@/Components/ui/button';
import { Input } from '@/Components/ui/input';
import { Label } from '@/Components/ui/label';
import { Card, CardContent, CardHeader, CardTitle } from '@/Components/ui/card';
import { 
    Lock, 
    Mail 
} from 'lucide-react';

// Komponen ikon Google kustom
const GoogleIcon = (props) => (
    <svg 
        xmlns="http://www.w3.org/2000/svg" 
        viewBox="0 0 48 48" 
        width="24" 
        height="24" 
        {...props}
    >
        <path fill="#FFC107" d="M43.611 20.083H42V20H24v8h11.303c-1.649 4.657-6.08 8-11.303 8-6.627 0-12-5.373-12-12s5.373-12 12-12c3.059 0 5.842 1.154 7.961 3.039l5.657-5.657C34.046 6.053 29.268 4 24 4 12.955 4 4 12.955 4 24s8.955 20 20 20 20-8.955 20-20c0-1.341-.138-2.65-.389-3.917z"/>
        <path fill="#FF3D00" d="m6.306 14.691 6.571 4.819C14.655 15.108 18.961 12 24 12c3.059 0 5.842 1.154 7.961 3.039l5.657-5.657C34.046 6.053 29.268 4 24 4 16.318 4 9.656 8.337 6.306 14.691z"/>
        <path fill="#4CAF50" d="M24 44c5.166 0 9.86-1.977 13.409-5.192l-6.19-5.238A11.91 11.91 0 0 1 24 36c-5.202 0-9.619-3.317-11.283-7.946l-6.522 5.025C9.505 39.556 16.227 44 24 44z"/>
        <path fill="#1976D2" d="M43.611 20.083H42V20H24v8h11.303a12.04 12.04 0 0 1-4.087 5.571l.003-.002 6.19 5.238C36.971 39.801 44 34 44 24c0-1.341-.138-2.65-.389-3.917z"/>
    </svg>
);

export default function Login() {
    const { data, setData, post, processing, errors } = useForm({
        email: '',
        password: '',
    });

    const handleSubmit = (e) => {
        e.preventDefault();
        post(route('login'));
    };

    return (
        <div className="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 to-blue-100">
            <Head title="Login" />
            
            <Card className="w-full max-w-md shadow-2xl">
                <CardHeader className="text-center">
                    <CardTitle className="text-3xl font-bold text-blue-800">
                        Revolusi Pemesanan Makanan
                    </CardTitle>
                    <p className="text-gray-500 mt-2">
                        Masuk ke akun Anda
                    </p>
                </CardHeader>
                <CardContent>
                    <form onSubmit={handleSubmit} className="space-y-4">
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
                                placeholder="Masukkan password Anda"
                                required
                                className={errors.password ? 'border-red-500' : ''}
                            />
                            {errors.password && (
                                <p className="text-red-500 text-sm mt-1">{errors.password}</p>
                            )}
                        </div>

                        <div className="flex justify-between items-center">
                            <Link 
                                href={route('password.request')} 
                                className="text-sm text-blue-600 hover:underline"
                            >
                                Lupa Password?
                            </Link>
                        </div>

                        <Button 
                            type="submit" 
                            className="w-full"
                            disabled={processing}
                        >
                            {processing ? 'Logging in...' : 'Masuk'}
                        </Button>

                        <div className="relative my-4">
                            <div className="absolute inset-0 flex items-center">
                                <div className="w-full border-t border-gray-300"></div>
                            </div>
                            <div className="relative flex justify-center text-sm">
                                <span className="px-2 bg-white text-gray-500">
                                    Atau lanjutkan dengan
                                </span>
                            </div>
                        </div>

                        <Button 
                            type="button" 
                            variant="outline" 
                            className="w-full flex items-center justify-center"
                            onClick={() => window.location.href = route('google.redirect')}
                        >
                            <GoogleIcon className="mr-2 h-5 w-5" /> 
                            Masuk dengan Google
                        </Button>

                        <div className="text-center mt-4">
                            <p className="text-sm text-gray-600">
                                Belum punya akun? {' '}
                                <Link 
                                    href={route('register')} 
                                    className="text-blue-600 hover:underline"
                                >
                                    Daftar Sekarang
                                </Link>
                            </p>
                        </div>
                    </form>
                </CardContent>
            </Card>
        </div>
    );
}