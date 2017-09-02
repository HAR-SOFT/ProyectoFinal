draw2d.atributoNombre=function()
{
  draw2d.ImageFigure.call(this,this.type+".png");
  this.outputPort = null;
  this.inputPort= null;
  this.setDimension(100,30);

};

draw2d.atributoNombre.prototype = new draw2d.ImageFigure();
draw2d.atributoNombre.prototype.type="atributoNombre";

draw2d.atributoNombre.prototype.setWorkflow=function(/*:draw2d.Workflow*/ workflow)
{
  draw2d.ImageFigure.prototype.setWorkflow.call(this,workflow);

  if(workflow!==null && this.outputPort===null && this.inputPort===null)
  {
    this.outputPort = new draw2d.OutputPort();
    this.outputPort.setMaxFanOut(5); // It is possible to add "5" Connector to this port
    this.outputPort.setWorkflow(workflow);
    this.outputPort.setBackgroundColor(new  draw2d.Color(245,115,115));
    this.addPort(this.outputPort,this.width,this.height/2);
	
  }
};
