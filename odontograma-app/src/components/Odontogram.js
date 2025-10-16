import React, { useState } from 'react';
import './odontogram.css';

const Odontogram = () => {
    const [procedures, setProcedures] = useState({
        tooth1: 'to-do',
        tooth2: 'to-do',
        tooth3: 'to-do',
        tooth4: 'to-do',
        tooth5: 'to-do',
        tooth6: 'to-do',
        tooth7: 'to-do',
        tooth8: 'to-do',
        tooth9: 'to-do',
        tooth10: 'to-do',
        tooth11: 'to-do',
        tooth12: 'to-do',
        tooth13: 'to-do',
        tooth14: 'to-do',
        tooth15: 'to-do',
        tooth16: 'to-do',
    });

    const handleClick = (tooth) => {
        setProcedures((prev) => {
            const currentStatus = prev[tooth];
            if (currentStatus === 'to-do') {
                return { ...prev, [tooth]: 'in-progress' };
            } else if (currentStatus === 'in-progress') {
                return { ...prev, [tooth]: 'completed' };
            } else {
                return { ...prev, [tooth]: 'to-do' };
            }
        });
    };

    const getColor = (status) => {
        switch (status) {
            case 'to-do':
                return 'lightgray';
            case 'in-progress':
                return 'yellow';
            case 'completed':
                return 'green';
            default:
                return 'lightgray';
        }
    };

    return (
        <div className="odontogram">
            {Object.keys(procedures).map((tooth) => (
                <div
                    key={tooth}
                    className="tooth"
                    style={{ backgroundColor: getColor(procedures[tooth]) }}
                    onClick={() => handleClick(tooth)}
                >
                    {tooth}
                </div>
            ))}
        </div>
    );
};

export default Odontogram;