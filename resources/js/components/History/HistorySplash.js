import React from "react";
import ReactDOM from "react-dom";

import Chart from "react-apexcharts";

class HistorySplash extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            data: {
                bootsWornFor: '',
            },
            series: [{
                name: '',
                data: []
            }],
            options: {
                chart: {
                    type: 'bar',
                    weight: "100%",
                    height: "100%",
                    background: '#fff'
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '55%',
                        endingShape: 'rounded'
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                },
                xaxis: {
                    title: {
                        text: 'Days'
                    },
                    categories: [],
                },
                yaxis: {
                    title: {
                        text: 'Hours'
                    }
                },
                fill: {
                    opacity: 1,
                    colors: [function ({value}) {
                        if (value < 12) {
                            return '#FF0000'
                        } else if (value >= 12 && value < 14) {
                            return '#FFA500'
                        } else {
                            return '#008000'
                        }
                    }]
                },
                tooltip: {
                    y: {
                        formatter: function (val) {
                            return val + " hours"
                        }
                    }
                }
            },
            responsive: [
                {
                    breakpoint: 1000,
                    options: {
                        legend: {
                            position: "bottom"
                        }
                    }
                }
            ]
        };
    }

    async componentDidMount() {
        await axios.get(`/progress-so-far`)
            .then(r => {
                this.setState({
                    data: {
                        bootsWornFor: r.data.boots_worn_for
                    },
                    series: [{
                        name: 'Hours Boots Worn',
                        data: r.data.hours
                    }],
                    options: {
                        xaxis: {
                            categories: r.data.days
                        }
                    }
                })
            })
    }

    render() {
        return (
            <div id="chart" className={"text-center mt-4"}>
                <h1 className={"text-xl font-bold"}>Your Progress so far</h1>
                <p>You've been using the Boots and Bars for </p>
                <p className={"text-purple-400"}>{this.state.data.bootsWornFor} Weeks</p>

                <p>And you're daily average is </p>
                <p className={"text-green-400"}>15.6 hours</p>
                <p>So you're doing well!</p>
                <Chart
                    className={"inline-block md:w-1/3"}
                    options={this.state.options}
                    series={this.state.series}
                    type="bar"
                />
                <p className={"text-sm"}>Tap to see more from previous weeks</p>
            </div>
        )
    }
}

export default HistorySplash;

if (document.getElementById('history')) {
    ReactDOM.render(<HistorySplash/>, document.getElementById('history'));
}
