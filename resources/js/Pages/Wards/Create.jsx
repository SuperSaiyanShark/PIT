import { useState } from 'react';
import { Link, router } from '@inertiajs/react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import PrimaryButton from '@/Components/PrimaryButton';
import InputLabel from '@/Components/InputLabel';
import TextInput from '@/Components/TextInput';
import InputError from '@/Components/InputError';
import { Head } from '@inertiajs/react';

export default function WardsCreate({ departments = [], heads = [] }) {
    const [formData, setFormData] = useState({
        name: '',
        department_id: '',
        floor: '',
        capacity: '',
        ward_head_id: '',
    });
    const [errors, setErrors] = useState({});
    const [isLoading, setIsLoading] = useState(false);

    const handleChange = (e) => {
        const { name, value } = e.target;
        setFormData(prev => ({ ...prev, [name]: value }));
        if (errors[name]) setErrors(prev => ({ ...prev, [name]: '' }));
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        setIsLoading(true);
        router.post(route('wards.store'), formData, {
            onSuccess: () => setIsLoading(false),
            onError: (newErrors) => { setErrors(newErrors); setIsLoading(false); }
        });
    };

    return (
        <AuthenticatedLayout>
            <Head title="Add New Ward" />
            <div className="min-h-screen bg-gradient-to-br from-cyan-100 to-cyan-50 p-8">
                <div className="mb-8 flex items-center gap-4">
                    <Link href={route('wards.index')}>
                        <button className="text-cyan-600 hover:text-cyan-800 font-semibold">← Back to Wards</button>
                    </Link>
                    <h1 className="text-3xl font-bold text-cyan-600">Add New Ward</h1>
                </div>
                <div className="bg-white rounded-lg shadow-md p-8 max-w-2xl">
                    <form onSubmit={handleSubmit} className="space-y-6">
                        <div>
                            <InputLabel htmlFor="name" value="Ward Name *" />
                            <TextInput id="name" name="name" type="text" className="mt-1 block w-full" value={formData.name} onChange={handleChange} placeholder="e.g., ICU Ward A" required />
                            {errors.name && <InputError message={errors.name} />}
                        </div>
                        <div>
                            <InputLabel htmlFor="department_id" value="Department *" />
                            <select id="department_id" name="department_id" className="mt-1 block w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500" value={formData.department_id} onChange={handleChange} required>
                                <option value="">Select a department</option>
                                {departments.map(d => <option key={d.id} value={d.id}>{d.name}</option>)}
                            </select>
                            {errors.department_id && <InputError message={errors.department_id} />}
                        </div>
                        <div className="grid grid-cols-2 gap-6">
                            <div>
                                <InputLabel htmlFor="floor" value="Floor" />
                                <TextInput id="floor" name="floor" type="number" className="mt-1 block w-full" value={formData.floor} onChange={handleChange} placeholder="e.g., 2" />
                                {errors.floor && <InputError message={errors.floor} />}
                            </div>
                            <div>
                                <InputLabel htmlFor="capacity" value="Capacity (beds)" />
                                <TextInput id="capacity" name="capacity" type="number" className="mt-1 block w-full" value={formData.capacity} onChange={handleChange} placeholder="e.g., 20" min="1" />
                                {errors.capacity && <InputError message={errors.capacity} />}
                                {formData.capacity && (
                                    <p className="text-xs text-gray-500 mt-1">
                                        ⚠️ Max staff allowed: {Math.max(3, Math.min(10, Math.floor(formData.capacity / 2)))}
                                    </p>
                                )}
                            </div>
                        </div>
                        <div>
                            <InputLabel htmlFor="ward_head_id" value="Ward Head (optional)" />
                            <select id="ward_head_id" name="ward_head_id" className="mt-1 block w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500" value={formData.ward_head_id} onChange={handleChange}>
                                <option value="">Select ward head (optional)</option>
                                {heads.map(h => <option key={h.id} value={h.id}>{h.name} ({h.role})</option>)}
                            </select>
                            {errors.ward_head_id && <InputError message={errors.ward_head_id} />}
                        </div>
                        <div className="flex gap-4 pt-4 border-t">
                            <PrimaryButton disabled={isLoading}>{isLoading ? 'Saving...' : 'Create Ward'}</PrimaryButton>
                            <Link href={route('wards.index')}>
                                <button type="button" className="px-6 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition">Cancel</button>
                            </Link>
                        </div>
                    </form>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}