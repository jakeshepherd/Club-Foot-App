import React from "react";
import ReactDOM from "react-dom";

import Chart from "react-apexcharts";

class HistorySplash extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            series: [{
                name: '',
                data: []
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
        };
    }

    async componentDidMount() {
        await axios.get(`progress-so-far`)
            .then(r => {
                this.setState({
                    series: [{
                        name: 'Hours Boots Worn',
                        data: r.data.hours
                    }],
                    options: {
                        xaxis:  {
                            categories: r.data.days
                        }
                    }
                })
            })
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
                    width="600"
                    height="300"
                />
            </div>
        )
    }
}

export default HistorySplash;

if (document.getElementById('history')) {
    ReactDOM.render(<HistorySplash/>, document.getElementById('history'));
}
