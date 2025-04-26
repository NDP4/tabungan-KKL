export class SavingsChart {
    constructor(canvasId) {
        this.chart = null;
        this.canvasId = canvasId;
    }

    async initialize() {
        const response = await fetch("/api/savings/statistics");
        const data = await response.json();
        this.render(data.chart_data);
    }

    render(data) {
        const ctx = document.getElementById(this.canvasId).getContext("2d");

        if (this.chart) {
            this.chart.destroy();
        }

        this.chart = new Chart(ctx, {
            type: "line",
            data: {
                labels: data.labels,
                datasets: [
                    {
                        label: "Total Tabungan",
                        data: data.values,
                        borderColor: "rgb(79, 70, 229)",
                        backgroundColor: "rgba(79, 70, 229, 0.1)",
                        fill: true,
                        tension: 0.4,
                    },
                ],
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: "top",
                    },
                    title: {
                        display: true,
                        text: "Progres Tabungan KKL",
                    },
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function (value) {
                                return (
                                    "Rp " +
                                    new Intl.NumberFormat("id-ID").format(value)
                                );
                            },
                        },
                    },
                },
            },
        });
    }

    async refresh() {
        const response = await fetch("/api/savings/statistics");
        const data = await response.json();
        this.update(data.chart_data);
    }

    update(data) {
        this.chart.data.labels = data.labels;
        this.chart.data.datasets[0].data = data.values;
        this.chart.update();
    }
}

export class ClassProgressChart {
    constructor(canvasId) {
        this.chart = null;
        this.canvasId = canvasId;
    }

    async initialize() {
        const response = await fetch("/api/savings/class-progress");
        const data = await response.json();
        this.render(data.progress_data);
    }

    render(data) {
        const ctx = document.getElementById(this.canvasId).getContext("2d");

        if (this.chart) {
            this.chart.destroy();
        }

        this.chart = new Chart(ctx, {
            type: "bar",
            data: {
                labels: data.labels,
                datasets: [
                    {
                        label: "Progress (%)",
                        data: data.values,
                        backgroundColor: Array(data.values.length).fill(
                            "rgb(79, 70, 229)"
                        ),
                    },
                ],
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: "top",
                    },
                    title: {
                        display: true,
                        text: "Progress Tabungan per Mahasiswa",
                    },
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        ticks: {
                            callback: function (value) {
                                return value + "%";
                            },
                        },
                    },
                },
            },
        });
    }

    async refresh() {
        const response = await fetch("/api/savings/class-progress");
        const data = await response.json();
        this.update(data.progress_data);
    }

    update(data) {
        this.chart.data.labels = data.labels;
        this.chart.data.datasets[0].data = data.values;
        this.chart.update();
    }
}
