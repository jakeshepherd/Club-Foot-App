import React from "react";
import ReactDOM from "react-dom";

import Chart from "react-apexcharts";

class HistorySplash extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            series: [{
                name: 'Hours boots worn',
                data: [12, 15, 17, 16, 11, 8, 13, 10, 16]
            }],
            options: {
                chart: {
                    type: 'bar',
                    height: 350,
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
                    categories: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
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
        };
    }

    render() {
        return (
            <div id="chart" className={"text-center"}>
                <p>Your Progress so far</p>
                <Chart
                    className={"inline-block"}
                    options={this.state.options}
                    series={this.state.series}
                    type="bar"
                    width="500"
                />
            </div>
        )
    }
}

export default HistorySplash;

if (document.getElementById('history')) {
    ReactDOM.render(<HistorySplash/>, document.getElementById('history'));
}
