draw2d.RelacionVive=function()
{
  draw2d.ImageFigure.call(this,this.type+".png");
  this.outputPort = null;
  this.inputPort= null;
  this.setDimension(75,90);

};

draw2d.RelacionVive.prototype = new draw2d.ImageFigure();
draw2d.RelacionVive.prototype.type="RelacionVive";

draw2d.RelacionVive.prototype.setWorkflow=function(/*:draw2d.Workflow*/ workflow)
{
  draw2d.ImageFigure.prototype.setWorkflow.call(this,workflow);

  if(workflow!==null && this.outputPort===null && this.inputPort===null)
  {
    this.outputPort = new draw2d.OutputPort();
    this.outputPort.setMaxFanOut(5); // It is possible to add "5" Connector to this port
    this.outputPort.setWorkflow(workflow);
    this.outputPort.setBackgroundColor(new  draw2d.Color(245,115,115));
    this.addPort(this.outputPort,this.width,this.height/2);
	 // create a new Port element. Ports can be children of "Node" elements.
    // (Inheritance: End->Image->Node->Figure->Object)
    this.inputPort = new draw2d.InputPort();

    // set the paintarea/canvas for this port figure
    this.inputPort.setWorkflow(workflow);

    // set background color of the port
    this.inputPort.setBackgroundColor(new  draw2d.Color(115,115,245));

    // Add the port to this object at the left/middle position
    this.addPort(this.inputPort,0,this.height/2);
  }
};
