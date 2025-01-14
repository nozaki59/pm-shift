import './app.js';
import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin from '@fullcalendar/interaction';
import timeGridPlugin from '@fullcalendar/timegrid';
import jaLocale from '@fullcalendar/core/locales/ja';
import axios from 'axios';

document.addEventListener('DOMContentLoaded', function() {
    const calendarEl = document.getElementById('calendar');

    // FullCalendarの初期化
    const calendar = new Calendar(calendarEl, {
        plugins: [dayGridPlugin, interactionPlugin, timeGridPlugin],
        initialView: 'dayGridMonth',
        firstDay: 1, // 週の最初を月曜日に設定
        weekends: false, // 土日を非表示
        locale: jaLocale, // 日本語化
        events: '/api/shifts',  // getShiftsメソッドのエンドポイント
        eventDisplay: 'block', // イベントをブロック要素として表示
        displayEventTime: false, // イベントの時間を非表示
        eventTimeFormat: {
            hour: '2-digit',
            minute: '2-digit',
            meridiem: false
        },
    });

    calendar.render();
});
