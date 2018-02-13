import React, { Component } from 'react';

export default class Tab extends Component {
    render() {
        return (
            <div>
                {this.props.children}
            </div>
        );
    }
}