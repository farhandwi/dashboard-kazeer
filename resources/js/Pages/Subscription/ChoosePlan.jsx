import React from 'react';
import { Head, router, usePage } from '@inertiajs/react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Button } from '@/Components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/Components/ui/card';
import { Check, PlusCircle } from 'lucide-react';

export default function ChoosePlan() {
    const { plans, hasMerchant, auth } = usePage().props;

    const handlePlanSelect = (plan) => {
        if (hasMerchant) {
            router.post(route('subscription.process'), { plan_id: plan.id });
        }
    };

    const handleCreateMerchant = () => {
        router.visit(route('subscription.create-merchant'));
    };

    return (
        <AuthenticatedLayout user={auth.user}>
            <Head title="Pilih Paket Langganan" />

            <div className="py-12">
                <div className="max-w-screen-xl mx-auto px-4">
                    {!hasMerchant ? (
                        <div className="bg-white shadow-md rounded-lg p-8 text-center mb-12">
                            <h2 className="text-2xl font-bold text-gray-800 mb-4">
                                Lengkapi Informasi Merchant Anda
                            </h2>
                            <p className="text-gray-600 mb-6">
                                Sebelum memilih paket langganan, silakan lengkapi profil merchant terlebih dahulu.
                            </p>
                            <Button 
                                onClick={handleCreateMerchant}
                                className="mx-auto"
                                size="lg"
                            >
                                <PlusCircle className="mr-2 h-5 w-5" />
                                Buat Profil Merchant
                            </Button>
                        </div>
                    ) : (
                        <h1 className="text-3xl font-bold text-center mb-12">
                            Pilih Paket Langganan Kazeer
                        </h1>
                    )}

                    <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
                        {plans.map((plan) => (
                            <Card 
                                key={plan.id}
                                className={`
                                    border-2 transition-all duration-300
                                    ${!hasMerchant 
                                        ? 'opacity-50 cursor-not-allowed' 
                                        : 'hover:border-blue-500'}
                                `}
                            >
                                <CardHeader>
                                    <CardTitle>{plan.name}</CardTitle>
                                </CardHeader>
                                <CardContent>
                                    <p className="text-4xl font-bold text-blue-600 mb-4">
                                        {plan.price === 0 ? 'Gratis' : `Rp ${plan.price.toLocaleString()}`}
                                        <span className="text-sm block text-gray-500">
                                            per {plan.duration_days} hari
                                        </span>
                                    </p>

                                    <ul className="mb-6 space-y-3 text-gray-600">
                                        {plan.features.map((feature, index) => (
                                            <li key={index} className="flex items-center">
                                                <Check className="mr-2 h-5 w-5 text-green-500" />
                                                {feature}
                                            </li>
                                        ))}
                                    </ul>

                                    <Button 
                                        onClick={() => handlePlanSelect(plan)}
                                        className="w-full"
                                        disabled={!hasMerchant}
                                    >
                                        {hasMerchant 
                                            ? `Pilih Paket ${plan.name}` 
                                            : 'Lengkapi Merchant Terlebih Dahulu'}
                                    </Button>
                                </CardContent>
                            </Card>
                        ))}
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}