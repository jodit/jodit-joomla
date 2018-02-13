import React, { Component } from 'react';
import style from './style.module.css';

export default class CopyText extends Component {
    state = {
        mode: 'ready'
    };

    onClick = () => {
        const textarea = document.createElement('textarea');

        document.body.appendChild(textarea);
        textarea.value = this.refs.codebox.innerText;
        textarea.select();
        document.execCommand('copy');
        document.body.removeChild(textarea);

        this.setState({
            mode: 'copied'
        });

        setTimeout(() => {
            if (this.state.mode === 'copied') {
                this.setState({
                    mode: 'ready'
                });
            }
        }, 1000);
    };
    render = () => (
        <div className={style.item}>
            <button className={style.button + ' ' + style[this.state.mode]} onClick={this.onClick} type="button">
                {this.state.mode === 'ready' ? 'Copy code' : 'Copied!'}
            </button>
            <div ref="codebox">
                {this.props.children}
            </div>
        </div>
    );
}