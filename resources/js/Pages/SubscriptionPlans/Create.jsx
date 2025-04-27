import React, { useState } from 'react';
import { Link, useForm } from '@inertiajs/react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Button } from '@/Components/ui/button';
import { Input } from '@/Components/ui/input';
import { Label } from '@/Components/ui/label';
import { Textarea } from '@/Components/ui/textarea';
import { Switch } from '@/Components/ui/switch';
import { Card, CardContent, CardHeader, CardTitle } from '@/Components/ui/card';
import { PlusCircle, Trash2 } from 'lucide-react';

export default function CreateSubscriptionPlan({ auth }) {
    const { data, setData, post, processing, errors } = useForm({
        name: '',
        description: '',
        price: '',
        duration_days: '',
        is_active: true,
        features: []
    });

    const addFeature = () => {
        setData('features', [...data.features, '']);
    };

    const removeFeature = (index) => {
        const newFeatures = data.features.filter((_, i) => i !== index);
        setData('features', newFeatures);
    };

    const updateFeature = (index, value) => {
        const newFeatures = [...data.features];
        newFeatures[index] = value;
        setData('features', newFeatures);
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        post(route('subscription-plans.store'));
    };

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                    Create Subscription Plan
                </h2>
            }
        >
            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <Card>
                        <CardHeader>
                            <CardTitle>New Subscription Plan</CardTitle>
                        </CardHeader>
                        <CardContent>
                            <form onSubmit={handleSubmit} className="space-y-4">
                                <div className="grid md:grid-cols-2 gap-4">
                                    <div>
                                        <Label>Plan Name</Label>
                                        <Input 
                                            value={data.name}
                                            onChange={(e) => setData('name', e.target.value)}
                                            className={errors.name ? 'border-red-500' : ''}
                                        />
                                        {errors.name && (
                                            <p className="text-red-500 text-sm mt-1">{errors.name}</p>
                                        )}
                                    </div>
                                    <div>
                                        <Label>Price (IDR)</Label>
                                        <Input 
                                            type="number"
                                            value={data.price}
                                            onChange={(e) => setData('price', e.target.value)}
                                            className={errors.price ? 'border-red-500' : ''}
                                        />
                                        {errors.price && (
                                            <p className="text-red-500 text-sm mt-1">{errors.price}</p>
                                        )}
                                    </div>
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
                                        <Label>Duration (Days)</Label>
                                        <Input 
                                            type="number"
                                            value={data.duration_days}
                                            onChange={(e) => setData('duration_days', e.target.value)}
                                            className={errors.duration_days ? 'border-red-500' : ''}
                                        />
                                        {errors.duration_days && (
                                            <p className="text-red-500 text-sm mt-1">{errors.duration_days}</p>
                                        )}
                                    </div>
                                    <div>
                                        <Label>Active Status</Label>
                                        <div className="flex items-center space-x-2">
                                            <Switch
                                                checked={data.is_active}
                                                onCheckedChange={(checked) => setData('is_active', checked)}
                                            />
                                            <Label>{data.is_active ? 'Active' : 'Inactive'}</Label>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <div className="flex justify-between items-center mb-2">
                                    <div className="flex justify-between items-center mb-2">
                                            <Label>Features</Label>
                                            <Button 
                                                type="button" 
                                                variant="outline" 
                                                size="sm"
                                                onClick={addFeature}
                                            >
                                                <PlusCircle className="mr-2 h-4 w-4" /> Add Feature
                                            </Button>
                                        </div>
                                        {data.features.map((feature, index) => (
                                            <div key={index} className="flex items-center space-x-2 mb-2">
                                                <Input 
                                                    value={feature}
                                                    onChange={(e) => updateFeature(index, e.target.value)}
                                                    placeholder="Enter feature"
                                                    className="flex-grow"
                                                />
                                                <Button 
                                                    type="button"
                                                    variant="destructive"
                                                    size="sm"
                                                    onClick={() => removeFeature(index)}
                                                >
                                                    <Trash2 className="h-4 w-4" />
                                                </Button>
                                            </div>
                                        ))}
                                    </div>
                                </div>

                                <div className="flex justify-end space-x-4 mt-6">
                                    <Link href={route('subscription-plans.index')}>
                                        <Button type="button" variant="outline">
                                            Cancel
                                        </Button>
                                    </Link>
                                    <Button 
                                        type="submit" 
                                        disabled={processing}
                                    >
                                        {processing ? 'Creating...' : 'Create Plan'}
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