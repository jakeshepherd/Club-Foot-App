import React from "react";
import ReactDOM from "react-dom";

import Chart from "react-apexcharts";
import {toast} from "react-toastify";
import ReactTooltip from "react-tooltip";

class HistorySplash extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            dataAvailable: true,
            data: {},
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
                            return '#fda0a0'
                        } else if (value >= 12 && value <= 14) {
                            return '#FFD877'
                        } else {
                            return '#a7f3d0'
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
        await axios.get(`/boots-time-goal`)
            .then(r => {
                this.setState({
                    time_goal: r.data / 60
                })
            }).catch(() => {
                toast.info('⏰ Please set a time goal by going into your settings in your account.')
            })
        await axios.get(`/progress-so-far`)
            .then(r => {
                if (r.data !== "") {
                    this.setState({
                        dataAvailable: true,
                        data: {
                            timeBootsWornFor: r.data.boots_worn_for,
                            totalAverageHours: Math.floor(r.data.total_average / 60),
                            totalAverageMinutes: Math.round(r.data.total_average % 60),
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
                } else {
                    this.setState({dataAvailable: false})
                }
            })
    }

    render() {
        return (
            <div id="chart" className={"text-center mt-4"}>
                <h1 className={"text-xl font-bold"}>Your Boots and Bars time so far</h1>
                {this.state.dataAvailable && <p>You've been using the Boots and Bars for </p>}
                {this.state.dataAvailable &&
                <p className={"text-purple-400"}>{this.state.data.timeBootsWornFor} Weeks</p>}
                {this.state.dataAvailable && <p>And your total daily average is </p>}
                {this.state.dataAvailable && this.state.data.totalAverageHours > this.state.time_goal &&
                <p className={"text-green-400"}>
                    {this.state.data.totalAverageHours} hours {this.state.data.totalAverageMinutes} mins
                </p>}

                {this.state.dataAvailable && this.state.data.totalAverageHours < this.state.time_goal &&
                <p className={"text-yellow-500"}>
                    {this.state.data.totalAverageHours} hours {this.state.data.totalAverageMinutes} mins
                </p>}

                {this.state.dataAvailable && this.state.data.totalAverageHours > this.state.time_goal &&
                <p className={"mt-4"}>So you're doing well!</p>}
                {this.state.dataAvailable && this.state.data.totalAverageHours < this.state.time_goal &&
                <p className={"mt-4"}>
                    This is less than your time goal.
                    <br/>
                    Why don't you check out the <a className={"text-blue-600 underline"} href={'/FAQ'}>FAQs</a> to see
                    if this can support you to reach your goal?

                </p>
                }

                {this.state.dataAvailable && this.state.data.totalAverageHours < this.state.time_goal &&
                <p className={"text-base mt-2"}>Also, to update your time goal, please access settings in the top
                    right.</p>
                }

                {this.state.dataAvailable && <Chart
                    className={"inline-block md:w-1/3"}
                    options={this.state.options}
                    series={this.state.series}
                    type="bar"
                />}
                {!this.state.dataAvailable &&
                <p className={"mt-4 text-xl text-blue-500"}>When there is some data available, it will show up here</p>}
                <br/>
                <a className={"text-sm cursor-pointer"}
                   href="/more-history">
                    Tap to see more from previous weeks</a>
                <ReactTooltip multiline={true}/>
            </div>
        )
    }

}

export default HistorySplash;

if (document.getElementById('history')) {
    ReactDOM.render(<HistorySplash/>, document.getElementById('history'));
}
