draw2d.ToolUndo=function(/*:draw2d.PaletteWindow*/ palette)
{
  draw2d.Button.call(this,palette);
};

draw2d.ToolUndo.prototype = new draw2d.Button();
/** @private **/
draw2d.ToolUndo.prototype.type="ToolUndo";


draw2d.ToolUndo.prototype.execute=function()
{
  this.palette.workflow.getCommandStack().undo();

  draw2d.ToolGeneric.prototype.execute.call(this);
};
