import { l10n } from '../../../core/global/config/app-config.js'


export function initializeAttemptsCharts() {
    var ctx = document.getElementById('kt_chartjs_1');

    // Define colors
    var dangerColor = KTUtil.getCssVariableValue('--kt-danger');
    var successColor = KTUtil.getCssVariableValue('--kt-success');

    // Get chart data from data attributes
    const chartData = JSON.parse(ctx.dataset.chartData);

    // Chart data
    const data = {
        labels: chartData.map(item => {
            const date = new Date(item.date);
            return date.toLocaleDateString('en-US', {
                month: 'short',
                day: 'numeric'
            });
        }),
        datasets: [{
            label: 'Passed Attempts',
            data: chartData.map(item => item.passed),
            backgroundColor: successColor,
            borderColor: successColor,
            tension: 0.4,
            fill: false
        },
        {
            label: 'Failed Attempts',
            data: chartData.map(item => item.failed),
            backgroundColor: dangerColor,
            borderColor: dangerColor,
            tension: 0.4,
            fill: false
        }
        ]
    };

    // Chart config
    const config = {
        type: 'line',
        data: data,
        options: {
            plugins: {
                title: {
                    display: true,
                    text: 'Daily Quiz Attempts (Last 7 Days)'
                },
                legend: {
                    position: 'bottom'
                }
            },
            responsive: true,
            interaction: {
                intersect: false,
                mode: 'index'
            },
            scales: {
                x: {
                    ticks: {
                        maxRotation: 45,
                        minRotation: 45
                    }
                },
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            }
        }
    };

    var myChart = new Chart(ctx, config);
}

export function initializeQuizStatusChart() {
    const ctx = document.getElementById('quiz-status-chart');
    const chartData = JSON.parse(ctx.dataset.chartData);

    // Define colors
    const colors = {
        passed: KTUtil.getCssVariableValue('--kt-success'),
        failed: KTUtil.getCssVariableValue('--kt-danger'),
        aborted: KTUtil.getCssVariableValue('--kt-warning')
    };

    // Format dates for labels
    const formatDate = (dateString) => {
        return new Date(dateString).toLocaleDateString('en-US', {
            month: 'short',
            day: 'numeric'
        });
    };

    // Prepare the data
    const labels = chartData.map(item => formatDate(item.date));
    const datasets = [
        {
            label: l10n.getCommon('passed'),
            data: chartData.map(item => item.passed),
            backgroundColor: colors.passed,
            borderColor: colors.passed,
            borderWidth: 1
        },
        {
            label: l10n.getCommon('failed'),
            data: chartData.map(item => item.failed),
            backgroundColor: colors.failed,
            borderColor: colors.failed,
            borderWidth: 1
        },
        {
            label: l10n.getCommon('aborted'),
            data: chartData.map(item => item.aborted),
            backgroundColor: colors.aborted,
            borderColor: colors.aborted,
            borderWidth: 1,
        }
    ];

    // Chart configuration
    const config = {
        type: 'bar',
        data: {
            labels: labels,
            datasets: datasets
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: l10n.getCommon('quizAttemptStatus'),
                    font: {
                        family: `${l10n.currentLocale === 'ar' ? 'Changa' : '"Playwrite GB S", cursive'}`
                    }
                },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                    font: {
                        family: `${l10n.currentLocale === 'ar' ? 'Changa' : '"Playwrite GB S", cursive'}`
                    }
                },
                legend: {
                    position: 'bottom',
                    font: {
                        family: `${l10n.currentLocale === 'ar' ? 'Changa' : '"Playwrite GB S", cursive'}`
                    }
                }
            },
            scales: {
                x: {
                    stacked: true,
                    title: {
                        display: true,
                        text: 'Date',
                        font: {
                            family: `${l10n.currentLocale === 'ar' ? 'Changa' : '"Playwrite GB S", cursive'}`
                        }
                    }
                },
                y: {
                    stacked: true,
                    title: {
                        display: true,
                        text: l10n.getCommon('numberOfAttempts'),
                        font: {
                            family: `${l10n.currentLocale === 'ar' ? 'Changa' : '"Playwrite GB S", cursive'}`
                        }
                    },
                    ticks: {
                        stepSize: 1,
                        precision: 0,
                        font: {
                            family: `${l10n.currentLocale === 'ar' ? 'Changa' : '"Playwrite GB S", cursive'}`
                        }
                    }
                }
            }
        }
    };

    // Create the chart
    new Chart(ctx, config);
}

export function initializePerformanceDistributionChart() {
    const chartElements = document.querySelectorAll('.performance-distribution-chart');

    chartElements.forEach(ctx => {
        if (!ctx) return;

        let chartData;
        try {
            const parsedData = JSON.parse(ctx.dataset.chartData);
            chartData = Array.isArray(parsedData) ? parsedData[0] : parsedData;
        } catch (e) {
            chartData = {
                excellent: 0,
                good: 0,
                average: 0,
                below_average: 0
            };
        }

        const totalAttempts = Number(chartData.excellent || 0) +
            Number(chartData.good || 0) +
            Number(chartData.average || 0) +
            Number(chartData.below_average || 0);

        const data = [
            totalAttempts ? (Number(chartData.below_average || 0) / totalAttempts) * 100 : 0,
            totalAttempts ? (Number(chartData.average || 0) / totalAttempts) * 100 : 0,
            totalAttempts ? (Number(chartData.good || 0) / totalAttempts) * 100 : 0,
            totalAttempts ? (Number(chartData.excellent || 0) / totalAttempts) * 100 : 0
        ];

        const ctx2 = ctx.getContext('2d');

        // Create gradient for the line
        const gradientStroke = ctx2.createLinearGradient(0, 0, 400, 0);
        gradientStroke.addColorStop(0, 'rgba(247, 126, 21, 0.8)');
        gradientStroke.addColorStop(1, 'rgba(255, 145, 50, 0.8)');

        // Create gradient for the fill
        const gradientFill = ctx2.createLinearGradient(0, 0, 0, ctx.height);
        gradientFill.addColorStop(0, 'rgba(247, 126, 21, 0.2)');
        gradientFill.addColorStop(1, 'rgba(247, 126, 21, 0.02)');

        const config = {
            type: 'line',
            data: {
                labels: ['Below Average', 'Average', 'Good', 'Excellent'],
                datasets: [{
                    label: 'Performance',
                    data: data,
                    backgroundColor: gradientFill,
                    borderColor: gradientStroke,
                    borderWidth: 2,
                    tension: 0.3,
                    fill: true,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: 'rgba(247, 126, 21, 0.8)',
                    pointRadius: 4,
                    pointBorderWidth: 2,
                    pointHoverRadius: 6,
                    pointHoverBorderWidth: 2,
                    pointHoverBackgroundColor: '#fff',
                    pointHoverBorderColor: 'rgba(247, 126, 21, 1)',
                    shadowColor: 'rgba(247, 126, 21, 0.3)',
                    shadowBlur: 10,
                    shadowOffsetX: 0,
                    shadowOffsetY: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: {
                    duration: 1000
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        grid: {
                            color: (context) => {
                                const value = context.tick.value;
                                if (value === 0 || value === 25 || value === 50 || value === 75 || value === 100) {
                                    return 'rgba(166, 166, 166, 0.27)';
                                }
                                return 'transparent';
                            },
                            drawBorder: false,
                            drawTicks: false
                        },
                        ticks: {
                            callback: value => `${Math.round(value)}%`,
                            color: 'rgba(148, 148, 148, 0.8)',
                            font: {
                                size: 10
                            },
                            stepSize: 25,
                            autoSkip: false,
                            maxTicksLimit: 5
                        },
                        border: {
                            display: true,
                            color: 'rgba(166, 166, 166, 0.27)',
                            width: 1,
                            dash: [4, 4]
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: 'rgba(148, 148, 148, 0.8)',
                            font: {
                                size: 10
                            }
                        },
                        border: {
                            display: false
                        }
                    }
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'Quiz Performance',
                        color: 'rgba(148, 148, 148, 0.8)',
                        font: {
                            size: 12,
                            family: "'Inter', sans-serif",
                            weight: '500'
                        },
                        padding: {
                            top: 5,
                            bottom: 15
                        }
                    },
                    legend: {
                        display: false
                    },
                    tooltip: {
                        padding: 10,
                        borderColor: 'rgba(247, 126, 21, 0.2)',
                        borderWidth: 1,
                        cornerRadius: 4,
                        displayColors: false,
                        callbacks: {
                            label: (context) => {
                                const percentage = context.raw.toFixed(0);
                                const actualCount = Math.round((percentage / 100) * totalAttempts);
                                return `${percentage}% (${actualCount} attempts)`;
                            }
                        }
                    }
                }
            },
            plugins: [{
                beforeDraw: (chart) => {
                    const ctx = chart.ctx;
                    ctx.shadowColor = 'rgba(247, 126, 21, 0.15)';
                    ctx.shadowBlur = 10;
                }
            }]
        };

        new Chart(ctx, config);
    });
}


