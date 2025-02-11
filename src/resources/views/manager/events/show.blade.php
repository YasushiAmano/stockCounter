<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            イベント詳細
        </h2>
    </x-slot>

    <div class="pt-4 pb-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="max-w-2xl mx-auto py-4">
                    <x-validation-errors class="mb-4" />

                    @session('status')
                        <div class="mb-4 font-medium text-sm text-green-600">
                            {{ $value }}
                        </div>
                    @endsession
                    <form method="GET" action="{{ route('events.edit', ['event' => $event->id]) }}">
                        <div class="mt-4">
                            <x-label for="name" value="イベント名" />
                            {{ $event->name }}
                        </div>
                        <div class="mt-4">
                            <x-label for="information" value="イベント詳細" />
                            {!! nl2br(e($event->information)) !!}
                        </div>
                        <div class="md:flex justify-between">
                            <div class="mt-4">
                                <x-label for="event_date" value="イベント日付" />
                                {{ $event->event_date }}
                            </div>
                            <div class="mt-4">
                                <x-label for="start_time" value="開始時間" />
                                {{ $event->start_time }}
                            </div>
                            <div class="mt-4">
                                <x-label for="end_time" value="終了時間" />
                                {{ $event->end_time }}
                            </div>
                        </div>
                        <div class="md:flex justify-between item-end">
                            <div class="mt-4">
                                <x-label for="max_people" value="定員" />
                                {{ $event->max_people }}
                            </div>
                            <div class="mt-4">
                                <div class="flex space-x-4 justify-around mt-4">
                                    @if ($event->is_visible)
                                        表示
                                    @else
                                        非表示
                                    @endif
                                </div>
                            </div>
                            <div class="mt-4">
                                @if ($event->event_date >= Carbon\Carbon::today()->format('Y年m月d日'))
                                    <x-button class="mt-4 ms-4">
                                        編集
                                    </x-button>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="max-w-2xl mx-auto py-4">
                    @if (!$users->isEmpty())
                        <div class="text-center py-4">予約状況</div>
                        <table class="table-auto w-full text-left whitespace-no-wrap">
                            <thead>
                                <tr>
                                    <th
                                        class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                        予約者名
                                    </th>
                                    <th
                                        class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                        予約人数
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($reservations as $reservation)
                                    @if (empty($reservation['canceled_date']))
                                        <tr>
                                            <td class="px-4 py-3">
                                                {{ $reservation['user_name'] }}
                                            </td>
                                            <td class="px-4 py-3">
                                                {{ $reservation['number_of_people'] }}
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
