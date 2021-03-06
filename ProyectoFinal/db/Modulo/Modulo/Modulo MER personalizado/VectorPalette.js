draw2d.VectorPalette=function()
{
  draw2d.ToolPalette.call(this, "Tools");

  // undo / redo support
  //
  this.undoTool = new draw2d.ToolUndo(this);
  this.undoTool.setPosition(13,10);
  this.undoTool.setEnabled(false);
  this.addChild(this.undoTool);


  this.redoTool = new draw2d.ToolRedo(this);
  this.redoTool.setPosition(43,10);
  this.redoTool.setEnabled(false);
  this.addChild(this.redoTool);

  this.setDimension(170,53);
};

draw2d.VectorPalette.prototype = new draw2d.ToolPalette();
/** @private */
draw2d.VectorPalette.prototype.type="VectorPalette";


draw2d.VectorPalette.prototype.onSetDocumentDirty=function()
{
  this.undoTool.setEnabled(this.workflow.getCommandStack().canUndo());
  this.redoTool.setEnabled(this.workflow.getCommandStack().canRedo());
};
