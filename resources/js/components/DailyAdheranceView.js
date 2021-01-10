import { data } from 'autoprefixer';
import React from 'react';


function DailyAdheranceView(props) {
    return (
        <div>
            {Object.entries(props.data).map(([key, value]) => {
                if (value) {
                    return (
                        <div key={key} className="daily-adherance border-green-200">
                            {key[0]}
                        </div>
                    )
                } else {
                    return (
                        <div key={key} className="daily-adherance border-red-200">
                            {key[0]}
                        </div>
                    )
                }
            })}
        </div>
    )
}

export default DailyAdheranceView