import React, { Component } from 'react';
import './App.css';
import JoditMaster from "./components/master/JoditMaster";


class App extends Component {
  config;
  constructor() {
    super();
    this.config = {
        showCode: true,
        showEditor: true,
        showButtonsTab: true,
        setCode: (code) => {},
        setConfig: (config) => {},
        initialConfig: {},
      ...window.JoditPlayConfig
    };
  }

  render() {
    return (
      <div className="App">
          <JoditMaster config={this.config}/>
      </div>
    );
  }
}

export default App;
