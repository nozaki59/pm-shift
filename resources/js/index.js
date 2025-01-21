import './app.js';
import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin from '@fullcalendar/interaction';
import timeGridPlugin from '@fullcalendar/timegrid';
import jaLocale from '@fullcalendar/core/locales/ja';
import axios from 'axios';

document.addEventListener('DOMContentLoaded', function () {
    // カレンダー処理
    const calendarEl = document.getElementById('calendar');

    // FullCalendarの初期化
    const calendar = new Calendar(calendarEl, {
        plugins: [dayGridPlugin, interactionPlugin, timeGridPlugin],
        initialView: 'timeGridWeek', // 週表示
        firstDay: 1, // 週の最初を月曜日に設定
        weekends: false, // 土日を非表示
        locale: jaLocale, // 日本語化
        events: '/api/shifts', // getShiftsメソッドのエンドポイント
        eventDisplay: 'block', // イベントをブロック要素として表示
        displayEventTime: false, // イベントの時間を非表示
        allDaySlot: false, // 終日スロットを非表示
        slotEventOverlap: false, // イベントの重なりを許可しない
        slotMinTime: '06:00:00', // スロットの最小時間
        slotMaxTime: '22:00:00', // スロットの最大時間
        height: 'auto', // カレンダーの高さを自動調整
        eventTimeFormat: {
            hour: '2-digit',
            minute: '2-digit',
            meridiem: false,
        },
    });

    calendar.render();

    // スクロール処理
    const fcColHeader = document.querySelector('.fc-col-header').clientWidth;
    const fcBody = document.querySelector('.fc-timegrid-body table');
    fcBody.style.width = `${fcColHeader}px`;

    // 横スクロール同期処理
    const header = document.querySelector('.fc-scrollgrid-section-header .fc-scroller');
    const content = document.querySelector('.fc-scrollgrid-section-body .fc-scroller');

    if (header && content) {
        content.addEventListener('scroll', function () {
            header.scrollLeft = content.scrollLeft;
        });

        header.addEventListener('scroll', function () {
            content.scrollLeft = header.scrollLeft;
        });
    }

    // 時間表示のsticky
    // 必要な要素のサイズを取得
    const timeWidth = document.querySelector('.fc-timegrid-slot-label').clientWidth;
    const timeHeight = 25;
    const GridHeight = document.querySelector('.fc-timegrid-cols .fc-timegrid-axis').clientHeight - 25;

    // 対象のラッパー要素を取得
    const timeGridWrapper = document.querySelector('.fc-view-harness-passive');

    // `timeGrid`要素を作成
    const timeGrid = document.createElement('div');
    timeGrid.className = `time-sticky md:hidden absolute top-0 left-0 z-50 bg-white`; // 固定クラスを設定
    timeGrid.setAttribute('style', `width: ${timeWidth}px; height: ${GridHeight}px; margin-top:25px;`); // 幅と高さを動的に設定

    // `@for`のループ部分をJavaScriptで生成
    for (let i = 6; i < 22; i++) {
        // 各時刻のラベルを表示するdivを作成
        const timeLabelDiv = document.createElement('div');
        timeLabelDiv.className = `w-full flex justify-center items-center`; // 固定クラスを設定
        timeLabelDiv.setAttribute('style', `height: ${timeHeight}px;`); // 高さを動的に設定

        const timeLabelP = document.createElement('p');
        timeLabelP.textContent = `${i}時`; // テキスト内容を設定
        timeLabelDiv.appendChild(timeLabelP);

        // 空のdivを作成
        const emptyDiv = document.createElement('div');
        emptyDiv.className = `w-full`; // 固定クラスを設定
        emptyDiv.setAttribute('style', `height: ${timeHeight}px;`); // 高さを動的に設定

        // `timeGrid`に追加
        timeGrid.appendChild(timeLabelDiv);
        timeGrid.appendChild(emptyDiv);
    }

    // 作成した`timeGrid`を`timeGridWrapper`の最後に挿入
    timeGridWrapper.insertAdjacentElement('beforeend', timeGrid);

    // イベントの幅を調整
    setTimeout(() => {
        document.querySelectorAll('.fc-timegrid-event').forEach(function (event) {
            event.style.width = 'fit-content';
        });
    }, 300);

});
