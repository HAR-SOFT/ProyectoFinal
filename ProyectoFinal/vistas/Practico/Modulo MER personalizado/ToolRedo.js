draw2d.ToolRedo=function(/*:draw2d.PaletteWindow*/ palette)
{
  draw2d.Button.call(this,palette);
};

draw2d.ToolRedo.prototype = new draw2d.Button();
/** @private */
draw2d.ToolRedo.prototype.type="ToolRedo";


draw2d.ToolRedo.prototype.execute=function()
{
  this.palette.workflow.getCommandStack().redo();

  draw2d.ToolGeneric.prototype.execute.call(this);
};
