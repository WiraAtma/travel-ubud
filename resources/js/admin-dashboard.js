import Chart from 'chart.js/auto';

// ─── Palette ────────────────────────────────────────────────────────────────
const palette = {
    blue:    '#3b82f6',
    emerald: '#10b981',
    purple:  '#8b5cf6',
    orange:  '#f97316',
    rose:    '#f43f5e',
    yellow:  '#eab308',
    blueA:   'rgba(59,130,246,0.15)',
    emeraldA:'rgba(16,185,129,0.15)',
    purpleA: 'rgba(139,92,246,0.15)',
    orangeA: 'rgba(249,115,22,0.15)',
};

const defaultFont = { family: 'Inter, ui-sans-serif, system-ui, sans-serif', size: 11 };

Chart.defaults.font       = defaultFont;
Chart.defaults.color      = '#6b7280';
Chart.defaults.plugins.legend.labels.boxWidth  = 10;
Chart.defaults.plugins.legend.labels.padding   = 14;
Chart.defaults.plugins.legend.labels.usePointStyle = true;

// ─── 1. Content Growth — Multi-line ─────────────────────────────────────────
new Chart(document.getElementById('contentGrowthChart'), {
    type: 'line',
    data: {
        labels: contentGrowthData.labels,
        datasets: [
            {
                label: 'Destinasi',
                data: contentGrowthData.destinations,
                borderColor: palette.emerald,
                backgroundColor: palette.emeraldA,
                borderWidth: 2,
                pointRadius: 4,
                tension: 0.4,
                fill: true,
            },
            {
                label: 'Hotel',
                data: contentGrowthData.hotels,
                borderColor: palette.purple,
                backgroundColor: palette.purpleA,
                borderWidth: 2,
                pointRadius: 4,
                tension: 0.4,
                fill: true,
            },
            {
                label: 'Restoran',
                data: contentGrowthData.restaurants,
                borderColor: palette.orange,
                backgroundColor: palette.orangeA,
                borderWidth: 2,
                pointRadius: 4,
                tension: 0.4,
                fill: true,
            },
            {
                label: 'Artikel',
                data: contentGrowthData.articles,
                borderColor: palette.rose,
                backgroundColor: 'rgba(244,63,94,0.12)',
                borderWidth: 2,
                pointRadius: 4,
                tension: 0.4,
                fill: true,
            },
        ],
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        interaction: { mode: 'index', intersect: false },
        plugins: { legend: { position: 'bottom' } },
        scales: {
            x: { grid: { display: false } },
            y: { beginAtZero: true, ticks: { precision: 0 }, grid: { color: '#f3f4f6' } },
        },
    },
});

// ─── 2. User Growth — Bar ────────────────────────────────────────────────────
new Chart(document.getElementById('userGrowthChart'), {
    type: 'bar',
    data: {
        labels: userGrowthData.labels,
        datasets: [{
            label: 'User Baru',
            data: userGrowthData.data,
            backgroundColor: palette.blueA,
            borderColor: palette.blue,
            borderWidth: 2,
            borderRadius: 6,
        }],
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            x: { grid: { display: false } },
            y: { beginAtZero: true, ticks: { precision: 0 }, grid: { color: '#f3f4f6' } },
        },
    },
});

// ─── 3. Average Ratings — Horizontal Bar ────────────────────────────────────
new Chart(document.getElementById('avgRatingsChart'), {
    type: 'bar',
    data: {
        labels: avgRatingsData.labels,
        datasets: [{
            label: 'Avg Rating',
            data: avgRatingsData.data,
            backgroundColor: [palette.emeraldA, palette.purpleA, palette.orangeA],
            borderColor:     [palette.emerald,  palette.purple,  palette.orange],
            borderWidth: 2,
            borderRadius: 6,
        }],
    },
    options: {
        indexAxis: 'y',
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            x: { min: 0, max: 5, grid: { color: '#f3f4f6' } },
            y: { grid: { display: false } },
        },
    },
});

// ─── 4. Company Request Status — Doughnut ───────────────────────────────────
new Chart(document.getElementById('companyRequestChart'), {
    type: 'doughnut',
    data: {
        labels: companyRequestData.labels,
        datasets: [{
            data: companyRequestData.data,
            backgroundColor: [palette.yellow, palette.emerald, palette.rose],
            borderWidth: 0,
            hoverOffset: 8,
        }],
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '68%',
        plugins: {
            legend: { position: 'bottom' },
        },
    },
});

// ─── 5. Company Request Field — Polar Area ───────────────────────────────────
new Chart(document.getElementById('companyFieldChart'), {
    type: 'polarArea',
    data: {
        labels: companyFieldData.labels,
        datasets: [{
            data: companyFieldData.data,
            backgroundColor: [palette.orangeA, palette.emeraldA, palette.purpleA],
            borderColor:     [palette.orange,  palette.emerald,  palette.purple],
            borderWidth: 2,
        }],
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { position: 'bottom' } },
        scales: {
            r: { ticks: { precision: 0 }, grid: { color: '#f3f4f6' } },
        },
    },
});