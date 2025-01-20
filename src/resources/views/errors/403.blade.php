<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h1 class="text-2xl font-bold mb-4">アクセス権限がありません</h1>
                <p class="mb-4">このページにアクセスする権限がありません。</p>
                <a href="{{ route('dashboard') }}" class="text-blue-600 hover:underline">
                    ダッシュボードに戻る
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
